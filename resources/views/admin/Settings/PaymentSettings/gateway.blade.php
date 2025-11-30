<div class="space-y-8">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('admin.payment_settings.gateways.title') }}</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('admin.payment_settings.gateways.subtitle') }}</p>
    </div>

    <form action="javascript:void(0)" method="POST" id="gatewayform" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Stripe Gateway -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl shadow-xl border border-blue-200 dark:border-blue-800 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <div class="flex items-center">
                    <div class="p-2 bg-white/20 rounded-lg mr-4">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ __('admin.payment_settings.gateways.stripe.title') }}</h3>
                        <p class="text-blue-100 mt-1">{{ __('admin.payment_settings.gateways.stripe.description') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.stripe.secret_key') }}
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" name="s_s_k" value="{{ $settings->s_s_k }}" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="sk_live_...">
                            <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg class="w-5 h-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.stripe.secret_key_help') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.stripe.public_key') }}
                            </span>
                        </label>
                        <input type="text" name="s_p_k" value="{{ $settings->s_p_k }}" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                               placeholder="pk_live_...">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.stripe.public_key_help') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PayPal Gateway -->
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-2xl shadow-xl border border-yellow-200 dark:border-yellow-800 overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                <div class="flex items-center">
                    <div class="p-2 bg-white/20 rounded-lg mr-4">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.162-.406c.014-.02.027-.04.04-.061.015-.02.031-.04.046-.061.008-.013.016-.025.023-.038.016-.025.031-.051.046-.077.008-.014.015-.027.023-.041.015-.027.029-.054.043-.082.007-.014.014-.027.021-.041.014-.027.027-.055.040-.083.006-.014.013-.027.019-.041.013-.028.026-.057.038-.085.006-.015.011-.029.017-.043.012-.029.023-.058.034-.087.005-.015.011-.03.016-.045.011-.03.021-.061.031-.092.005-.016.009-.032.014-.048.01-.031.019-.063.027-.095.004-.016.008-.032.012-.048.009-.032.017-.065.024-.098.004-.017.007-.033.01-.05.008-.033.015-.067.021-.101.003-.017.006-.034.009-.051.007-.035.013-.07.018-.106.003-.018.005-.036.007-.054.006-.036.011-.073.015-.11.002-.019.004-.037.005-.056.005-.039.008-.079.01-.119.001-.02.002-.04.003-.06.003-.041.005-.083.005-.125v-.007c0-.042-.002-.084-.005-.126-.001-.02-.002-.04-.003-.06-.002-.04-.005-.08-.01-.119-.001-.019-.003-.037-.005-.056-.004-.037-.009-.074-.015-.11-.002-.018-.004-.036-.007-.054-.005-.036-.011-.072-.018-.106-.003-.017-.006-.034-.009-.051-.006-.034-.013-.068-.021-.101-.003-.017-.006-.033-.01-.05-.007-.033-.015-.066-.024-.098-.004-.016-.008-.032-.012-.048-.008-.032-.017-.064-.027-.095-.005-.016-.009-.032-.014-.048-.01-.031-.02-.062-.031-.092-.005-.015-.01-.03-.016-.045-.011-.029-.022-.058-.034-.087-.006-.014-.011-.028-.017-.043-.012-.028-.025-.057-.038-.085-.006-.014-.013-.027-.019-.041-.013-.028-.026-.056-.04-.083-.007-.014-.014-.027-.021-.041-.014-.028-.028-.055-.043-.082-.008-.014-.015-.027-.023-.041-.015-.026-.03-.052-.046-.077-.007-.013-.015-.025-.023-.038-.015-.021-.031-.041-.046-.061-.013-.021-.026-.041-.04-.061z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ __('admin.payment_settings.gateways.paypal.title') }}</h3>
                        <p class="text-yellow-100 mt-1">{{ __('admin.payment_settings.gateways.paypal.description') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.paypal.client_id') }}
                            </span>
                        </label>
                        <input type="text" name="pp_ci" value="{{ $settings->pp_ci }}" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                               placeholder="PayPal Client ID'nizi girin">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.paypal.client_id_help') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.paypal.client_secret') }}
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" name="pp_cs" value="{{ $settings->pp_cs }}" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="PayPal Client Secret'ınızı girin">
                            <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg class="w-5 h-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.paypal.client_secret_help') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paystack Gateway -->
        <div class="bg-gradient-to-r from-green-50 to-teal-50 dark:from-green-900/20 dark:to-teal-900/20 rounded-2xl shadow-xl border border-green-200 dark:border-green-800 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                <div class="flex items-center">
                    <div class="p-2 bg-white/20 rounded-lg mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ __('admin.payment_settings.gateways.paystack.title') }}</h3>
                        <p class="text-green-100 mt-1">{{ __('admin.payment_settings.gateways.paystack.description') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-8 space-y-6">
                <!-- Callback URL Info -->
                <div class="bg-teal-50 dark:bg-teal-900/20 border border-teal-200 dark:border-teal-800 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-teal-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-teal-700 dark:text-teal-300">
                                <strong>{{ __('admin.payment_settings.gateways.paystack.important') }}:</strong> {{ __('admin.payment_settings.gateways.paystack.callback_help') }}<br>
                                <code class="bg-teal-100 dark:bg-teal-800 px-2 py-1 rounded text-xs font-mono">{{ $settings->site_address }}/dashboard/paystackcallback</code>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.paystack.public_key') }}
                            </span>
                        </label>
                        <input type="text" name="paystack_public_key" value="{{ $paystack->paystack_public_key }}" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                               placeholder="pk_test_... veya pk_live_...">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.paystack.public_key_help') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.paystack.secret_key') }}
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" name="paystack_secret_key" value="{{ $paystack->paystack_secret_key }}" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="sk_test_... veya sk_live_...">
                            <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg class="w-5 h-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.paystack.secret_key_help') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.paystack.url') }}
                            </span>
                        </label>
                        <input type="text" name="paystack_url" value="{{ $paystack->paystack_url }}" readonly
                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-gray-100 dark:bg-admin-600 dark:text-gray-300 rounded-xl cursor-not-allowed font-mono text-sm" 
                               placeholder="https://api.paystack.co">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.paystack.url_help') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.paystack.email') }}
                            </span>
                        </label>
                        <input type="email" name="paystack_email" value="{{ $paystack->paystack_email }}" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                               placeholder="merchant@example.com">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.paystack.email_help') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flutterwave Gateway -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl shadow-xl border border-purple-200 dark:border-purple-800 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-white/20 rounded-lg mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ __('admin.payment_settings.gateways.flutterwave.title') }}</h3>
                            <p class="text-purple-100 mt-1">{{ __('admin.payment_settings.gateways.flutterwave.description') }}</p>
                        </div>
                    </div>
                    <a href="https://dashboard.flutterwave.com/login" target="_blank" class="text-white/80 hover:text-white transition-colors text-sm underline">
                        Dashboard →
                    </a>
                </div>
            </div>
            
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.flutterwave.public_key') }}
                            </span>
                        </label>
                        <input type="text" name="flw_public_key" value="{{ $moresettings->flw_public_key }}" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                               placeholder="FLWPUBK_TEST-...">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.flutterwave.public_key_help') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.flutterwave.secret_key') }}
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" name="flw_secret_key" value="{{ $moresettings->flw_secret_key }}" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="FLWSECK_TEST-...">
                            <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg class="w-5 h-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.flutterwave.secret_key_help') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.flutterwave.secret_hash') }}
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" name="flw_secret_hash" value="{{ $moresettings->flw_secret_hash }}" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="Secret Hash'inizi girin">
                            <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg class="w-5 h-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.flutterwave.secret_hash_help') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Binance Gateway -->
        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-2xl shadow-xl border border-amber-200 dark:border-amber-800 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-yellow-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-white/20 rounded-lg mr-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L8.5 8.5H2L6.5 12L2 15.5H8.5L12 22L15.5 15.5H22L17.5 12L22 8.5H15.5L12 2Z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ __('admin.payment_settings.gateways.binance.title') }}</h3>
                            <p class="text-amber-100 mt-1">{{ __('admin.payment_settings.gateways.binance.description') }}</p>
                        </div>
                    </div>
                    <a href="https://merchant.binance.com/en" target="_blank" class="text-white/80 hover:text-white transition-colors text-sm underline">
                        Merchant Portal →
                    </a>
                </div>
            </div>
            
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.binance.api_key') }}
                            </span>
                        </label>
                        <input type="text" name="bnc_api_key" value="{{ $moresettings->bnc_api_key }}" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                               placeholder="Binance API Key'inizi girin">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.binance.api_key_help') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.payment_settings.gateways.binance.secret_key') }}
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" name="bnc_secret_key" value="{{ $moresettings->bnc_secret_key }}" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="Binance Secret Key'inizi girin">
                            <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg class="w-5 h-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.payment_settings.gateways.binance.secret_key_help') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-center pt-8">
            <button type="submit" class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span id="gatewayButtonText">{{ __('admin.payment_settings.gateways.save_all') }}</span>
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('gatewayform');
        const saveButton = form.querySelector('button[type="submit"]');
        const saveButtonText = document.getElementById('gatewayButtonText');
        
        // Form submission handling
        if (form && saveButton) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                saveButton.disabled = true;
                saveButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('admin.payment_settings.processing') }}...
                `;
                
                // The form handler is already defined in the parent component
                const gatewayform = document.getElementById('gatewayform');
                if (gatewayform) {
                    const event = new Event('submit');
                    gatewayform.dispatchEvent(event);
                }
            });
        }
        
        // Password toggle functionality
        const passwordToggles = document.querySelectorAll('.password-toggle');
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const showIcon = this.querySelector('.show-icon');
                const hideIcon = this.querySelector('.hide-icon');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    showIcon.classList.add('hidden');
                    hideIcon.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    showIcon.classList.remove('hidden');
                    hideIcon.classList.add('hidden');
                }
            });
        });
        
        // Input validation and formatting
        const apiKeyInputs = document.querySelectorAll('input[type="text"], input[type="password"]');
        apiKeyInputs.forEach(input => {
            if (!input.readOnly) {
                input.addEventListener('input', function() {
                    // Remove any spaces that might be accidentally pasted
                    this.value = this.value.trim();
                });
                
                input.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        this.value = this.value.trim();
                    }, 10);
                });
            }
        });
    });
</script>