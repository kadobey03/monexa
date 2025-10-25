<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class PhrasesController extends Controller
{
    /**
     * Display a listing of phrases/translations.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $language = $request->get('language', 'tr');
        
        // Get available languages
        $availableLanguages = $this->getAvailableLanguages();
        
        // Get phrases for selected language
        $phrases = $this->getPhrases($language, $search);
        
        return view('admin.phrases.index', [
            'title' => 'Dil/Cümle Yönetimi',
            'phrases' => $phrases,
            'availableLanguages' => $availableLanguages,
            'currentLanguage' => $language,
            'search' => $search
        ]);
    }

    /**
     * Store a newly created phrase.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'language' => 'required|string|in:tr,en,ar',
            'category' => 'nullable|string|max:100'
        ]);

        try {
            $this->savePhrase($request->language, $request->key, $request->value);
            
            return response()->json([
                'success' => true,
                'message' => 'Çeviri başarıyla eklendi.'
            ]);
        } catch (\Exception $e) {
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
        $request->validate([
            'value' => 'required|string',
            'language' => 'required|string|in:tr,en,ar'
        ]);

        try {
            $this->savePhrase($request->language, $key, $request->value);
            
            return response()->json([
                'success' => true,
                'message' => 'Çeviri başarıyla güncellendi.'
            ]);
        } catch (\Exception $e) {
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
        try {
            $this->deletePhrase($language, $key);
            
            return response()->json([
                'success' => true,
                'message' => 'Çeviri başarıyla silindi.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Çeviri silinirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available languages from lang directory.
     */
    private function getAvailableLanguages()
    {
        $langPath = resource_path('lang');
        $languages = [];
        
        if (File::exists($langPath)) {
            $directories = File::directories($langPath);
            foreach ($directories as $directory) {
                $langCode = basename($directory);
                $languages[$langCode] = $this->getLanguageName($langCode);
            }
        }
        
        // Add default languages if not exists
        if (empty($languages)) {
            $languages = [
                'tr' => 'Türkçe',
                'en' => 'English',
                'ar' => 'العربية'
            ];
        }
        
        return $languages;
    }

    /**
     * Get phrases for a specific language.
     */
    private function getPhrases($language, $search = null)
    {
        $phrases = [];
        $langPath = resource_path("lang/{$language}");
        
        if (File::exists($langPath)) {
            $files = File::files($langPath);
            
            foreach ($files as $file) {
                if ($file->getExtension() === 'php') {
                    $fileName = $file->getFilenameWithoutExtension();
                    $translations = include $file->getPathname();
                    
                    if (is_array($translations)) {
                        $this->flattenArray($translations, $phrases, $fileName);
                    }
                }
            }
        }
        
        // Filter by search term if provided
        if ($search) {
            $phrases = array_filter($phrases, function($phrase) use ($search) {
                return stripos($phrase['key'], $search) !== false || 
                       stripos($phrase['value'], $search) !== false;
            });
        }
        
        return $phrases;
    }

    /**
     * Flatten nested array to dot notation.
     */
    private function flattenArray($array, &$result, $prefix = '', $category = 'general')
    {
        foreach ($array as $key => $value) {
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;
            
            if (is_array($value)) {
                $this->flattenArray($value, $result, $newKey, $category);
            } else {
                $result[] = [
                    'key' => $newKey,
                    'value' => $value,
                    'category' => $category,
                    'updated_at' => now()->format('Y-m-d H:i:s')
                ];
            }
        }
    }

    /**
     * Save phrase to language file.
     */
    private function savePhrase($language, $key, $value)
    {
        $langPath = resource_path("lang/{$language}");
        
        if (!File::exists($langPath)) {
            File::makeDirectory($langPath, 0755, true);
        }
        
        // Determine which file to save to based on key
        $parts = explode('.', $key);
        $fileName = $parts[0] ?? 'custom';
        $filePath = "{$langPath}/{$fileName}.php";
        
        // Load existing translations or create new array
        $translations = File::exists($filePath) ? include $filePath : [];
        
        // Set the value using dot notation
        $this->setArrayValue($translations, $key, $value);
        
        // Save to file
        $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
        File::put($filePath, $content);
    }

    /**
     * Delete phrase from language file.
     */
    private function deletePhrase($language, $key)
    {
        $parts = explode('.', $key);
        $fileName = $parts[0] ?? 'custom';
        $filePath = resource_path("lang/{$language}/{$fileName}.php");
        
        if (File::exists($filePath)) {
            $translations = include $filePath;
            $this->unsetArrayValue($translations, $key);
            
            $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
            File::put($filePath, $content);
        }
    }

    /**
     * Set array value using dot notation.
     */
    private function setArrayValue(&$array, $key, $value)
    {
        $keys = explode('.', $key);
        $current = &$array;
        
        foreach ($keys as $k) {
            if (!isset($current[$k]) || !is_array($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }
        
        $current = $value;
    }

    /**
     * Unset array value using dot notation.
     */
    private function unsetArrayValue(&$array, $key)
    {
        $keys = explode('.', $key);
        $current = &$array;
        
        for ($i = 0; $i < count($keys) - 1; $i++) {
            if (!isset($current[$keys[$i]]) || !is_array($current[$keys[$i]])) {
                return;
            }
            $current = &$current[$keys[$i]];
        }
        
        unset($current[end($keys)]);
    }

    /**
     * Get language display name.
     */
    private function getLanguageName($code)
    {
        $names = [
            'tr' => 'Türkçe',
            'en' => 'English', 
            'ar' => 'العربية',
            'de' => 'Deutsch',
            'fr' => 'Français',
            'es' => 'Español',
            'it' => 'Italiano',
            'pt' => 'Português',
            'ru' => 'Русский'
        ];
        
        return $names[$code] ?? ucfirst($code);
    }
}