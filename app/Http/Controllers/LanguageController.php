<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Switch language and redirect back
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale = null, Request $request = null)
    {
        // CRITICAL DEBUG LOGGING
        \Log::info("🚀 LanguageController::switch() CALLED", [
            'url' => request()->url(),
            'method' => request()->method(),
            'locale_param' => $locale,
            'request_input_locale' => $request ? $request->input('locale') : 'no-request',
            'session_id' => session()->getId(),
            'before_session_locale' => Session::get('locale', 'not-set'),
            'before_app_locale' => App::getLocale()
        ]);
        
        // Handle both POST and GET requests
        if (!$locale) {
            $locale = $request->input('locale');
        }
        
        // Validate locale
        if (!in_array($locale, ['tr', 'ru'])) {
            $locale = 'tr'; // Default fallback
        }
        
        \Log::info("🚀 LanguageController VALIDATED LOCALE", [
            'validated_locale' => $locale
        ]);
        
        // Set locale in session
        Session::put('locale', $locale);
        App::setLocale($locale);
        
        \Log::info("🚀 LanguageController AFTER SETTING", [
            'session_locale' => Session::get('locale'),
            'app_locale' => App::getLocale(),
            'redirect_back_to' => url()->previous()
        ]);
        
        return redirect()->back()->with('success', __('common.language_changed'));
    }
    
    /**
     * Get available languages for API/AJAX calls
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableLanguages()
    {
        return response()->json([
            'success' => true,
            'languages' => [
                ['code' => 'tr', 'name' => 'Türkçe', 'flag' => '🇹🇷'],
                ['code' => 'ru', 'name' => 'Русский', 'flag' => '🇷🇺'],
            ],
            'current' => app()->getLocale()
        ]);
    }
    
    /**
     * Switch language via AJAX
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function switchAjax(Request $request)
    {
        $locale = $request->input('locale');
        
        // Validate locale
        if (!in_array($locale, ['tr', 'ru'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid language code'
            ], 400);
        }
        
        // Set locale in session
        Session::put('locale', $locale);
        App::setLocale($locale);
        
        return response()->json([
            'success' => true,
            'message' => __('common.language_changed'),
            'locale' => $locale
        ]);
    }
}