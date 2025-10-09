<div class="row">
    <div class="col-12">
        <form method="post" action="javascript:void(0)" id="updatepreference">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group col-md-6">
                    <h5 class="">İletişim E-postası</h5>
                    <input type="text" class="form-control  " name="contact_email"
                        value="{{ $settings->contact_email }}" required>
                </div>

                <input name="s_currency" value="{{ $settings->s_currency }}" id="s_c" type="hidden">
                <div class="form-group col-md-6">
                    <h5 class="">Web Sitesi Para Birimi</h5>
                    <select name="currency" id="select_c" class="form-control   select2" onchange="changecurr()"
                        style="width: 100%">
                        <option value="<?php echo htmlentities($settings->currency); ?>">{{ $settings->currency }}</option>
                        @foreach ($currencies as $key => $currency)
                            <option id="{{ $key }}" value="<?php echo html_entity_decode($currency); ?>">
                                {{ $key . ' (' . html_entity_decode($currency) . ')' }}</option>
                        @endforeach
                    </select>

                </div>
                <input type="hidden" value="{{ $settings->site_preference }}" name="site_preference">
                <div class="form-group col-md-6">
                    <h5 class="">Ana Sayfa URL'si (Yönlendirme)</h5>
                    <input type="text" class="form-control " name="redirect_url"
                        placeholder="eg https://myhomepage.com" value="{{ $settings->redirect_url }}">
                    <small>Özel bir ana sayfa kullanıyorsanız ve tüm isteklerin o sayfaya yönlendirilmesini istiyorsanız, lütfen URL'yi buraya girin, boş bırakılırsa sistem varsayılan ana sayfamızı/web sayfalarımızı kullanacaktır</small>
                </div>
            </div>

            <div class="mt-3 row">
                <div class="mt-4 col-md-6">
                    <h5 class="">Duyuru:</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="annouc" value="on" class="selectgroup-input"
                                {{ $settings->enable_annoc == 'on' ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="annouc" value="off" class="selectgroup-input"
                                {{ $settings->enable_annoc != 'on' ? 'checked' : '' }}>
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                </div>
                <div class="mt-4 col-md-6">
                    <h5 class="">Hafta Sonu Ticaret:</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="weekend_trade" value="on" class="selectgroup-input"
                                {{ $settings->weekend_trade == 'on' ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="weekend_trade"
                                {{ $settings->weekend_trade != 'on' ? 'checked' : '' }} value="off"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                    <div>
                        <small class="">kapalıysa, kullanıcılar hafta sonları ROI almayacak</small>
                    </div>
                </div>

                <div class="mt-4 col-md-6">
                    <h5 class="">Para Çekme</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="withdraw" id="withdraw" value="true"
                                class="selectgroup-input" {{ $settings->enable_with == 'true' ? 'checked' : '' }}>
                            <span class="selectgroup-button">Enable</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="withdraw"
                                {{ $settings->enable_with != 'true' ? 'checked' : '' }}value="false"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Disable</span>
                        </label>
                    </div>
                    <div>
                        <small class="">devre dışı bırakılırsa, kullanıcılar para çekme talebi gönderemeyecek</small>
                    </div>

                </div>

                <div class="mt-4 col-md-6">
                    <h5 class="">Google ReCaptcha:</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="captcha" value="true" class="selectgroup-input"
                                {{ $settings->captcha == 'true' ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="captcha" {{ $settings->captcha != 'true' ? 'checked' : '' }}
                                value="false" class="selectgroup-input">
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                    <div>
                        <small class="">açık ise, kullanıcılar kayıt sırasında google recaptcha testini geçmek zorunda kalacak, ayrıca kullanmadan önce web sitenizde google recaptcha'nın nasıl kurulacağını görün. <a
                                href="https://doc.onlinetrade.brynamics.xyz/details/how-to-add-google-recaptcha-"
                                target="_blank">Nasıl yapılır</a></small>
                    </div>

                </div>

                <div class="mt-4 col-md-6">
                    <h5 class="">Çeviri</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="googlet" id="googlet" value="on"
                                class="selectgroup-input" {{ $settings->google_translate == 'on' ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="googlet"
                                {{ $settings->google_translate != 'on' ? 'checked' : '' }} value="off"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                    <div>
                        <small class="">açık ise, kullanıcılar google çeviri aracılığıyla tercih ettikleri dili seçme seçeneğine sahip olacak</small>
                    </div>
                </div>

                <div class="mt-4 col-md-6">
                    <h5 class="">Ticaret Modu</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="trade_mode" value="on" class="selectgroup-input"
                                {{ $settings->trade_mode == 'on' ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="trade_mode"
                                {{ $settings->trade_mode != 'on' ? 'checked' : '' }} value="off"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                    <div>
                        <small class="">kapalıysa, kullanıcılar ROI'yi hiç almayacak.</small>
                    </div>
                </div>

                <div class="mt-4 col-md-6">
                    <h5 class="">KYC(Doğrulama)</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="enable_kyc" value="yes" class="selectgroup-input"
                                {{ $settings->enable_kyc == 'yes' ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="enable_kyc"
                                {{ $settings->enable_kyc != 'yes' ? 'checked' : '' }} value="no"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                    <div>
                        <small class="">açık ise, kullanıcılar para çekme talebi göndermeden önce gerekli belgeleri göndermek zorunda kalacak.</small>
                    </div>
                </div>

                <div class="mt-4 col-md-6">
                    <h5 class="">KYC(Doğrulama) Kayıt Sırasında</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="enable_kyc_registration" value="yes"
                                class="selectgroup-input"
                                {{ $settings->enable_kyc_registration == 'yes' ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="enable_kyc_registration"
                                {{ $settings->enable_kyc_registration != 'yes' ? 'checked' : '' }} value="no"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                    <div>
                        <small class="">açık ise, kullanıcılar kayıt sırasında doğrulama sürecinden geçmek zorunda kalacak ve yönetici tarafından doğrulanana kadar sisteminizde hiçbir işlem yapmalarına izin verilmeyecek. Bunun mevcut KYC'lerini tamamlamamış kullanıcıları etkileyeceğini unutmayın. <strong>Bir başvuru gönderdikten sonra, devam etmeden önce kullanıcıyı kendi tarafınızdan doğrulamak zorunda kalacaksınız.</strong>
                        </small>
                    </div>
                </div>

                <div class="mt-4 col-md-6">
                    <h5 class="">Google Girişi</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="social" id="social" value="yes"
                                class="selectgroup-input"
                                {{ $settings->enable_social_login == 'yes' ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="social"
                                {{ $settings->enable_social_login != 'yes' ? 'checked' : '' }} value="no"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                    <div>
                        <small class="">Google Girişi, kullanıcıların google hesaplarıyla giriş yapmalarına/kayıt olmalarına izin verir</small>
                    </div>
                </div>

                <div class="mt-4 col-md-6">
                    <h5 class="">E-posta Doğrulama</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="enail_verify" value="true" class="selectgroup-input"
                                {{ $settings->enable_verification == 'true' ? 'checked' : '' }}>
                            <span class="selectgroup-button">Enable</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="enail_verify"
                                {{ $settings->enable_verification != 'true' ? 'checked' : '' }} value="false"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Disable</span>
                        </label>
                    </div>
                    <div>
                        <small class="">E-posta doğrulaması devre dışı bırakılırsa kullanıcılara e-posta adreslerini doğrulamaları sorulmayacak.</small>
                    </div>
                </div>
                <div class="mt-4 col-md-6">
                    <h5 class="">Sermaye İadesi</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="return_capital" value="true" class="selectgroup-input"
                                {{ $settings->return_capital ? 'checked' : '' }}>
                            <span class="selectgroup-button">Yes</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="return_capital"
                                {{ !$settings->return_capital ? 'checked' : '' }} value="false"
                                class="selectgroup-input">
                            <span class="selectgroup-button">No</span>
                        </label>
                    </div>
                    <div>
                        <small class="">Sermaye iadesi Hayır ise, sistem yatırım planı süresi dolduktan sonra kullanıcıya sermayesini kredilendirmeyecek</small>
                    </div>
                </div>
                <div class="mt-4 col-md-6">
                    <h5 class="">Plan İptali</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="should_cancel_plan" value="1" class="selectgroup-input"
                                {{ $settings->should_cancel_plan ? 'checked' : '' }}>
                            <span class="selectgroup-button">On</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="should_cancel_plan"
                                {{ !$settings->should_cancel_plan ? 'checked' : '' }} value="0"
                                class="selectgroup-input">
                            <span class="selectgroup-button">Off</span>
                        </label>
                    </div>
                    <div>
                        <small class="">Kullanıcıların aktif yatırım planlarını iptal edebilmesini istiyorsanız açın. Planlarını iptal ettiklerinde sermayenin kullanıcı hesabına iade edileceğini unutmayın.</small>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <input type="submit" class="px-5 btn btn-primary btn-lg" value="Kaydet">
            </div>
        </form>
    </div>
</div>
