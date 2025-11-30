<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // DEBUG LOG - START
        $sessionLocale = Session::get('locale', 'not-set');
        $appLocaleStart = App::getLocale();
        $configLocale = config('app.locale');

        \Log::info("🔄 SetLocale Middleware STARTED", [
            'url' => $request->url(),
            'method' => $request->method(),
            'session_locale' => $sessionLocale,
            'app_locale_start' => $appLocaleStart,
            'config_locale' => $configLocale,
            'session_id' => session()->getId(),
            'is_admin_route' => $request->is('admin/*'),
            'route_name' => $request->route()?->getName()
        ]);

        $locale = Session::get('locale', config('app.locale'));

        // List of supported languages - updated to match the language component
        $supportedLanguages = [
            'en', 'es', 'fr', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ko',
            'ar', 'hi', 'tr', 'nl', 'sv', 'da', 'no', 'fi', 'pl',
            'cs', 'hu', 'ro', 'bg', 'hr', 'sk', 'sl', 'et', 'lv', 'lt',
            'uk', 'he', 'th', 'vi', 'id', 'ms', 'tl'
        ];

        if (in_array($locale, $supportedLanguages)) {
            App::setLocale($locale);
            
            // DEBUG LOG - AFTER SET
            $appLocaleAfter = App::getLocale();
            \Log::info("🔄 SetLocale Middleware AFTER SET", [
                'selected_locale' => $locale,
                'app_locale_after' => $appLocaleAfter,
                'locale_changed' => $appLocaleStart !== $appLocaleAfter
            ]);
        } else {
            // DEBUG LOG - UNSUPPORTED LOCALE
            \Log::warning("🔄 SetLocale Middleware UNSUPPORTED LOCALE", [
                'invalid_locale' => $locale,
                'falling_back_to' => $appLocaleStart
            ]);
        }

        return $next($request);
    }
}
