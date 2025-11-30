<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Services\TranslationService;
use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PhrasesController extends Controller
{
    protected TranslationRepositoryInterface $translationRepository;
    protected TranslationService $translationService;

    public function __construct(
        TranslationRepositoryInterface $translationRepository,
        TranslationService $translationService
    ) {
        $this->translationRepository = $translationRepository;
        $this->translationService = $translationService;
    }

    /**
     * Display a listing of phrases/translations.
     */
    public function index(Request $request)
    {
        // DEBUG: Check current admin
        $currentAdmin = auth()->guard('admin')->user();
        Log::info('Admin Debug Info:', [
            'admin_id' => $currentAdmin?->id,
            'admin_name' => $currentAdmin?->getFullName(),
            'is_super_admin' => $currentAdmin?->isSuperAdmin(),
            'auth_guard' => auth()->guard('admin')->check(),
            'auth_default' => auth()->check()
        ]);
        
        // Check permissions with admin guard
        Gate::forUser(auth()->guard('admin')->user())->authorize('view-translations');
        
        $search = $request->get('search');
        $language = $request->get('language', 'tr');
        $group = $request->get('group');
        $status = $request->get('status');
        $perPage = $request->get('per_page', 15);
        
        // Get available languages from database
        $availableLanguages = Language::active()->get()->pluck('name', 'code');
        
        // Get phrase groups
        $groups = Phrase::distinct('group')->pluck('group')->filter()->values();
        
        // Build query for phrases with translations
        $query = Phrase::with(['translations' => function ($query) use ($language) {
            $query->whereHas('language', function ($q) use ($language) {
                $q->where('code', $language);
            })->with('language');
        }]);
        
        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('key', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('translations', function ($query) use ($search) {
                      $query->where('translation', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Apply group filter
        if ($group) {
            $query->where('group', $group);
        }
        
        // Apply status filter
        if ($status) {
            if ($status === 'translated') {
                $query->whereHas('translations', function ($q) use ($language) {
                    $q->whereHas('language', function ($query) use ($language) {
                        $query->where('code', $language);
                    });
                });
            } elseif ($status === 'untranslated') {
                $query->whereDoesntHave('translations', function ($q) use ($language) {
                    $q->whereHas('language', function ($query) use ($language) {
                        $query->where('code', $language);
                    });
                });
            } elseif ($status === 'needs_review') {
                $query->whereHas('translations', function ($q) use ($language) {
                    $q->where('needs_update', true)
                      ->whereHas('language', function ($query) use ($language) {
                          $query->where('code', $language);
                      });
                });
            }
        }
        
        // Get paginated results
        $phrases = $query->orderBy('key')->paginate($perPage);
        
        // Get translation statistics
        $stats = $this->getTranslationStats($language);
        
        return view('admin.phrases.index', [
            'title' => 'Dil/Çeviri Yönetimi',
            'breadcrumbs' => [
                ['title' => 'Ana Sayfa', 'url' => route('admin.dashboard')],
                ['title' => 'Dil/Çeviri Yönetimi', 'url' => route('admin.phrases')]
            ],
            'phrases' => $phrases,
            'availableLanguages' => $availableLanguages,
            'groups' => $groups,
            'currentLanguage' => $language,
            'search' => $search,
            'selectedGroup' => $group,
            'selectedStatus' => $status,
            'stats' => $stats,
            'perPage' => $perPage
        ]);
    }

    /**
     * Store a newly created phrase.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage-translations');
        
        $request->validate([
            'key' => 'required|string|max:255|unique:phrases,key',
            'group' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'translations' => 'required|array',
            'translations.*.language_id' => 'required|exists:languages,id',
            'translations.*.translation' => 'required|string'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Create phrase
                $phrase = Phrase::create([
                    'key' => $request->key,
                    'group' => $request->group ?: 'general',
                    'description' => $request->description,
                    'usage_count' => 0
                ]);
                
                // Create translations
                foreach ($request->translations as $translation) {
                    PhraseTranslation::create([
                        'phrase_id' => $phrase->id,
                        'language_id' => $translation['language_id'],
                        'translation' => $translation['translation'],
                        'needs_update' => false,
                        'approved_at' => now(),
                        'approved_by' => auth()->guard('admin')->id()
                    ]);
                }
                
                // Log activity
                Log::info('Translation phrase created', [
                    'key' => $phrase->key,
                    'admin_id' => auth()->guard('admin')->id()
                ]);
            });
            
            // Clear cache
            $this->translationService->clearCache();
            
            return response()->json([
                'success' => true,
                'message' => 'Çeviri başarıyla eklendi.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating translation phrase', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Çeviri eklenirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified phrase.
     */
    public function update(Request $request, $key)
    {
        Gate::authorize('manage-translations');
        
        $request->validate([
            'translation' => 'required|string',
            'language_code' => 'required|string|exists:languages,code'
        ]);

        try {
            DB::transaction(function () use ($request, $key) {
                $phrase = Phrase::where('key', $key)->firstOrFail();
                $language = Language::where('code', $request->language_code)->firstOrFail();
                
                $translation = PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $language->id
                    ],
                    [
                        'translation' => $request->translation,
                        'needs_update' => false,
                        'approved_at' => now(),
                        'approved_by' => auth()->guard('admin')->id(),
                        'updated_at' => now()
                    ]
                );
                
                // Log activity
                Log::info('Translation updated', [
                    'key' => $key,
                    'language' => $request->language_code,
                    'admin_id' => auth()->guard('admin')->id()
                ]);
            });
            
            // Clear cache
            $this->translationService->clearCache();
            
            return response()->json([
                'success' => true,
                'message' => 'Çeviri başarıyla güncellendi.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating translation', [
                'key' => $key,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Çeviri güncellenirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified phrase.
     */
    public function destroy($language, $key)
    {
        Gate::authorize('manage-translations');
        
        try {
            DB::transaction(function () use ($language, $key) {
                $phrase = Phrase::where('key', $key)->firstOrFail();
                $lang = Language::where('code', $language)->firstOrFail();
                
                // Delete specific translation
                PhraseTranslation::where('phrase_id', $phrase->id)
                    ->where('language_id', $lang->id)
                    ->delete();
                
                // If no translations left, delete the phrase
                if ($phrase->translations()->count() === 0) {
                    $phrase->delete();
                }
                
                // Log activity
                Log::info('Translation deleted', [
                    'key' => $key,
                    'language' => $language,
                    'admin_id' => auth()->guard('admin')->id()
                ]);
            });
            
            // Clear cache
            $this->translationService->clearCache();
            
            return response()->json([
                'success' => true,
                'message' => 'Çeviri başarıyla silindi.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting translation', [
                'key' => $key,
                'language' => $language,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Çeviri silinirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get translation statistics.
     */
    private function getTranslationStats($languageCode)
    {
        $cacheKey = "translation_stats_{$languageCode}";
        
        return Cache::remember($cacheKey, 300, function () use ($languageCode) {
            $language = Language::where('code', $languageCode)->first();
            
            if (!$language) {
                return [];
            }
            
            $totalPhrases = Phrase::count();
            $translatedPhrases = Phrase::whereHas('translations', function ($query) use ($language) {
                $query->where('language_id', $language->id);
            })->count();
            
            $needsReview = PhraseTranslation::where('language_id', $language->id)
                ->where('needs_update', true)
                ->count();
                
            $completionPercentage = $totalPhrases > 0
                ? round(($translatedPhrases / $totalPhrases) * 100, 1)
                : 0;
            
            return [
                'total_phrases' => $totalPhrases,
                'translated_phrases' => $translatedPhrases,
                'untranslated_phrases' => $totalPhrases - $translatedPhrases,
                'needs_review' => $needsReview,
                'completion_percentage' => $completionPercentage
            ];
        });
    }
}