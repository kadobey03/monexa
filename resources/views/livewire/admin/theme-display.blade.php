<div>
    @if ($settings->theme == 'purposeTheme')
        <div class="space-y-6">
            <hr class="border-admin-200 dark:border-admin-700">
            <div class="flex flex-wrap gap-4 mt-4">
                <div class="w-full">
                    <h5 class="text-lg font-medium text-admin-700 dark:text-admin-300 mb-4">
                        Website theme colour. Double click to save.
                        <span class="text-sm text-admin-500 dark:text-admin-400">Current theme colour have a blue border</span>
                    </h5>
                </div>
                
                <div class="w-full md:w-1/3 p-2">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <button
                            class="p-3 mb-2 rounded-lg shadow-lg transition-all {{ $settings->website_theme == 'purpose.css' ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-admin-700 hover:shadow-xl' }} border-2 {{ $settings->website_theme == 'purpose.css' ? 'border-blue-500' : 'border-admin-200 dark:border-admin-600' }}"
                            wire:click="setTheme('purpose.css')"
                            type="button">
                            <img src="{{ asset('dash/images/purpose.png') }}" class="max-w-full h-auto rounded-lg" alt="Purpose Theme">
                        </button>
                    </div>
                </div>
                
                <div class="w-full md:w-1/3 p-2">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <button
                            class="p-3 mb-2 rounded-lg shadow-lg transition-all {{ $settings->website_theme == 'blue.css' ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-admin-700 hover:shadow-xl' }} border-2 {{ $settings->website_theme == 'blue.css' ? 'border-blue-500' : 'border-admin-200 dark:border-admin-600' }}"
                            wire:click="setTheme('blue.css')"
                            type="button">
                            <img src="{{ asset('dash/images/blue.png') }}" class="max-w-full h-auto rounded-lg" alt="Blue Theme">
                        </button>
                    </div>
                </div>
                
                <div class="w-full md:w-1/3 p-2">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <button
                            class="p-3 mb-2 rounded-lg shadow-lg transition-all {{ $settings->website_theme == 'green.css' ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-admin-700 hover:shadow-xl' }} border-2 {{ $settings->website_theme == 'green.css' ? 'border-blue-500' : 'border-admin-200 dark:border-admin-600' }}"
                            wire:click="setTheme('green.css')"
                            type="button">
                            <img src="{{ asset('dash/images/green.png') }}" class="max-w-full h-auto rounded-lg" alt="Green Theme">
                        </button>
                    </div>
                </div>
                
                <div class="w-full md:w-1/3 p-2">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <button
                            class="p-3 mb-2 rounded-lg shadow-lg transition-all {{ $settings->website_theme == 'brown.css' ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-admin-700 hover:shadow-xl' }} border-2 {{ $settings->website_theme == 'brown.css' ? 'border-blue-500' : 'border-admin-200 dark:border-admin-600' }}"
                            wire:click="setTheme('brown.css')"
                            type="button">
                            <img src="{{ asset('dash/images/brown.png') }}" class="max-w-full h-auto rounded-lg" alt="Brown Theme">
                        </button>
                    </div>
                </div>
                
                <div class="w-full md:w-1/3 p-2">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <button
                            class="p-3 mb-2 rounded-lg shadow-lg transition-all {{ $settings->website_theme == 'dark.css' ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-admin-700 hover:shadow-xl' }} border-2 {{ $settings->website_theme == 'dark.css' ? 'border-blue-500' : 'border-admin-200 dark:border-admin-600' }}"
                            wire:click="setTheme('dark.css')"
                            type="button">
                            <img src="{{ asset('dash/images/dark.png') }}" class="max-w-full h-auto rounded-lg" alt="Dark Theme">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
