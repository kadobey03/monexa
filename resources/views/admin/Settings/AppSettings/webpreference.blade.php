<div class="space-y-8">
    <form method="post" action="javascript:void(0)" id="updatepreference" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Basic Website Settings -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Temel Web Sitesi Ayarları</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">İletişim E-postası</label>
                    <input type="text" name="contact_email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" value="{{ $settings->contact_email }}" required>
                </div>
                
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Web Sitesi Para Birimi</label>
                    <input name="s_currency" value="{{ $settings->s_currency }}" id="s_c" type="hidden">
                    <select name="currency" id="select_c" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" onchange="changecurr()">
                        <option value="<?php echo htmlentities($settings->currency); ?>">{{ $settings->currency }}</option>
                        @foreach ($currencies as $key => $currency)
                            <option id="{{ $key }}" value="<?php echo html_entity_decode($currency); ?>">
                                {{ $key . ' (' . html_entity_decode($currency) . ')' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="lg:col-span-2 space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Ana Sayfa URL'si (Yönlendirme)</label>
                    <input type="text" name="redirect_url" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" placeholder="ör: https://myhomepage.com" value="{{ $settings->redirect_url }}">
                    <input type="hidden" value="{{ $settings->site_preference }}" name="site_preference">
                    <p class="text-xs text-gray-500">Özel bir ana sayfa kullanıyorsanız ve tüm isteklerin o sayfaya yönlendirilmesini istiyorsanız, lütfen URL'yi buraya girin, boş bırakılırsa sistem varsayılan ana sayfamızı/web sayfalarımızı kullanacaktır</p>
                </div>
            </div>
        </div>
        
        <!-- System Features -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Sistem Özellikleri</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Announcement Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Duyuru</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="annouc" value="on" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->enable_annoc == 'on' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="annouc" value="off" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->enable_annoc != 'on' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                </div>
                
                <!-- Weekend Trade Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Hafta Sonu Ticaret</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="weekend_trade" value="on" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->weekend_trade == 'on' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="weekend_trade" value="off" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->weekend_trade != 'on' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Kapalıysa, kullanıcılar hafta sonları ROI almayacak</p>
                </div>
                
                <!-- Withdrawal Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Para Çekme</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="withdraw" value="true" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->enable_with == 'true' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Etkin</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="withdraw" value="false" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->enable_with != 'true' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Devre Dışı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Devre dışı bırakılırsa, kullanıcılar para çekme talebi gönderemeyecek</p>
                </div>
                
                <!-- Google ReCaptcha Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Google ReCaptcha</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="captcha" value="true" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->captcha == 'true' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="captcha" value="false" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->captcha != 'true' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Açık ise, kullanıcılar kayıt sırasında google recaptcha testini geçmek zorunda kalacak. <a href="https://doc.onlinetrade.brynamics.xyz/details/how-to-add-google-recaptcha-" target="_blank" class="text-purple-600 hover:text-purple-800 underline">Nasıl yapılır</a></p>
                </div>
                
                <!-- Translation Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Çeviri</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="googlet" value="on" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->google_translate == 'on' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="googlet" value="off" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->google_translate != 'on' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Açık ise, kullanıcılar google çeviri aracılığıyla tercih ettikleri dili seçme seçeneğine sahip olacak</p>
                </div>
                
                <!-- Trade Mode Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Ticaret Modu</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="trade_mode" value="on" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->trade_mode == 'on' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="trade_mode" value="off" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 focus:ring-2" {{ $settings->trade_mode != 'on' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Kapalıysa, kullanıcılar ROI'yi hiç almayacak</p>
                </div>
            </div>
        </div>
        
        <!-- User Authentication & Verification -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-green-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Kullanıcı Doğrulama ve Güvenlik</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- KYC Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">KYC (Doğrulama)</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="enable_kyc" value="yes" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" {{ $settings->enable_kyc == 'yes' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="enable_kyc" value="no" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" {{ $settings->enable_kyc != 'yes' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Açık ise, kullanıcılar para çekme talebi göndermeden önce gerekli belgeleri göndermek zorunda kalacak</p>
                </div>
                
                <!-- KYC Registration Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">KYC Kayıt Sırasında</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="enable_kyc_registration" value="yes" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" {{ $settings->enable_kyc_registration == 'yes' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="enable_kyc_registration" value="no" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" {{ $settings->enable_kyc_registration != 'yes' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Açık ise, kullanıcılar kayıt sırasında doğrulama sürecinden geçmek zorunda kalacak ve yönetici tarafından doğrulanana kadar sisteminizde hiçbir işlem yapmalarına izin verilmeyecek. <strong>Bir başvuru gönderdikten sonra, devam etmeden önce kullanıcıyı kendi tarafınızdan doğrulamak zorunda kalacaksınız.</strong></p>
                </div>
                
                <!-- Google Login Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Google Girişi</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="social" value="yes" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" {{ $settings->enable_social_login == 'yes' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="social" value="no" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" {{ $settings->enable_social_login != 'yes' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Google Girişi, kullanıcıların google hesaplarıyla giriş yapmalarına/kayıt olmalarına izin verir</p>
                </div>
                
                <!-- Email Verification Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">E-posta Doğrulama</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="enail_verify" value="true" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" {{ $settings->enable_verification == 'true' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Etkin</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="enail_verify" value="false" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" {{ $settings->enable_verification != 'true' ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Devre Dışı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">E-posta doğrulaması devre dışı bırakılırsa kullanıcılara e-posta adreslerini doğrulamaları sorulmayacak</p>
                </div>
            </div>
        </div>
        
        <!-- Investment & Plan Settings -->
        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 rounded-xl p-6 border border-orange-200">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-orange-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h10zM4 8a1 1 0 011-1h1a1 1 0 010 2H5a1 1 0 01-1-1zm5 1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Yatırım ve Plan Ayarları</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Return Capital Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Sermaye İadesi</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="return_capital" value="true" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 focus:ring-orange-500 focus:ring-2" {{ $settings->return_capital ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Evet</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="return_capital" value="false" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 focus:ring-orange-500 focus:ring-2" {{ !$settings->return_capital ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Hayır</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Sermaye iadesi Hayır ise, sistem yatırım planı süresi dolduktan sonra kullanıcıya sermayesini kredilendirmeyecek</p>
                </div>
                
                <!-- Plan Cancellation Setting -->
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Plan İptali</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="should_cancel_plan" value="1" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 focus:ring-orange-500 focus:ring-2" {{ $settings->should_cancel_plan ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Açık</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="should_cancel_plan" value="0" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 focus:ring-orange-500 focus:ring-2" {{ !$settings->should_cancel_plan ? 'checked' : '' }}>
                            <span class="ml-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Kapalı</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Kullanıcıların aktif yatırım planlarını iptal edebilmesini istiyorsanız açın. Planlarını iptal ettiklerinde sermayenin kullanıcı hesabına iade edileceğini unutmayın</p>
                </div>
            </div>
        </div>
        
        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Kaydet
            </button>
        </div>
    </form>
</div>