<?php

if (!function_exists('phrase')) {
    /**
     * Get translation for the given key using database translation system.
     *
     * @param string $key Translation key (e.g., 'admin.managers.title')
     * @param array $parameters Optional parameters to replace in translation
     * @param string|null $locale Optional locale, defaults to current app locale
     * @return string
     */
    function phrase(string $key, array $parameters = [], ?string $locale = null): string
    {
        try {
            // TranslationRepository'yi resolve et
            $repository = app(\App\Contracts\Repositories\TranslationRepositoryInterface::class);
            
            // Eğer locale belirtilmemişse current locale'i kullan
            $locale = $locale ?: app()->getLocale();
            
            // Repository'den çeviriyi al (tam key ile)
            $translation = $repository->getTranslation($key, $locale);
            
            if ($translation && $translation->translation) {
                $result = $translation->translation;
                
                // Parametreleri değiştir
                if (!empty($parameters)) {
                    foreach ($parameters as $search => $replacement) {
                        $result = str_replace(':' . $search, $replacement, $result);
                    }
                }
                
                return $result;
            }
            
            // Fallback: key'i döndür
            return $key;
            
        } catch (\Exception $e) {
            // Hata durumunda key'i döndür ve loglama yap
            \Illuminate\Support\Facades\Log::warning('Phrase helper function error', [
                'key' => $key,
                'locale' => $locale,
                'parameters' => $parameters,
                'error' => $e->getMessage()
            ]);
            
            return $key;
        }
    }
}

if (!function_exists('phrase_plural')) {
    /**
     * Get plural translation for the given key using database translation system.
     *
     * @param string $key Translation key
     * @param int $count Count for pluralization
     * @param array $parameters Optional parameters to replace in translation
     * @param string|null $locale Optional locale, defaults to current app locale
     * @return string
     */
    function phrase_plural(string $key, int $count, array $parameters = [], ?string $locale = null): string
    {
        try {
            // TranslationService'i resolve et
            $translationService = app(\App\Services\TranslationService::class);
            
            // Eğer locale belirtilmemişse current locale'i kullan
            $locale = $locale ?: app()->getLocale();
            
            // TranslationService'den plural çeviriyi al
            return $translationService->getPlural($key, $count, $parameters, $locale);
            
        } catch (\Exception $e) {
            // Hata durumunda fallback phrase() kullan
            \Illuminate\Support\Facades\Log::warning('Phrase plural helper function error', [
                'key' => $key,
                'count' => $count,
                'locale' => $locale,
                'parameters' => $parameters,
                'error' => $e->getMessage()
            ]);
            
            return phrase($key, array_merge($parameters, ['count' => $count]), $locale);
        }
    }
}

if (!function_exists('phrase_exists')) {
    /**
     * Check if translation exists for the given key.
     *
     * @param string $key Translation key
     * @param string|null $locale Optional locale, defaults to current app locale
     * @return bool
     */
    function phrase_exists(string $key, ?string $locale = null): bool
    {
        try {
            // TranslationService'i resolve et
            $translationService = app(\App\Services\TranslationService::class);
            
            // Eğer locale belirtilmemişse current locale'i kullan
            $locale = $locale ?: app()->getLocale();
            
            // Çeviriyi al ve key ile karşılaştır
            $translation = $translationService->get($key, [], $locale);
            
            // Eğer translation key ile aynıysa, çeviri bulunamadı demektir
            return $translation !== $key;
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Phrase exists helper function error', [
                'key' => $key,
                'locale' => $locale,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}

if (!function_exists('set_phrase_locale')) {
    /**
     * Set locale for translation service.
     *
     * @param string $locale
     * @return void
     */
    function set_phrase_locale(string $locale): void
    {
        try {
            // TranslationService'i resolve et
            $translationService = app(\App\Services\TranslationService::class);
            
            // Locale'i set et
            $translationService->setLocale($locale);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Set phrase locale helper function error', [
                'locale' => $locale,
                'error' => $e->getMessage()
            ]);
        }
    }
}

if (!function_exists('get_phrase_locale')) {
    /**
     * Get current locale from translation service.
     *
     * @return string
     */
    function get_phrase_locale(): string
    {
        try {
            // TranslationService'i resolve et
            $translationService = app(\App\Services\TranslationService::class);
            
            // Current locale'i al
            return $translationService->getLocale();
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Get phrase locale helper function error', [
                'error' => $e->getMessage()
            ]);
            
            return app()->getLocale();
        }
    }
}