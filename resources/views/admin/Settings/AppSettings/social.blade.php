<div class="row">
    <div class="col-md-12">
        <form action="" method="post">
            @csrf

            <div class=" form-row">
                <div class="form-group col-md-12">
                    <div class="">
                        <h5 class="">{{ __('admin.settings.app.social.choose_social_login') }}</h5>
                        <div class="selectgroup">
                            <label class="selectgroup-item">
                                <input type="radio" name="social" id="both" value="both"
                                    class="selectgroup-input" checked="">
                                <span class="selectgroup-button">{{ __('admin.settings.app.social.both') }}</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="social" id="facebook" value="facebook"
                                    class="selectgroup-input">
                                <span class="selectgroup-button">{{ __('admin.settings.app.social.facebook') }}</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="social" id="google" value="google"
                                    class="selectgroup-input">
                                <span class="selectgroup-button">{{ __('admin.settings.app.social.google') }}</span>
                            </label>

                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6 facebook">
                    <h5 class="">{{ __('admin.settings.app.social.app_id') }}</h5>
                    <input type="email" name="site_name" class="form-control  " value="{{ $settings->site_name }}"
                        required>
                    <small>{{ __('admin.settings.app.social.from_facebook_developer') }}</small>
                </div>
                <div class="form-group col-md-6 facebook">
                    <h5 class="">{{ __('admin.settings.app.social.app_secret') }}</h5>
                    <input type="text" name="site_name" class="form-control  " value="{{ $settings->site_name }}"
                        required>
                    <small>{{ __('admin.settings.app.social.from_facebook_developer') }}</small>
                </div>
                <div class="form-group col-md-6 facebook">
                    <h5 class="">{{ __('admin.settings.app.social.redirect_url') }}</h5>
                    <input type="text" name="site_name" class="form-control  " value="{{ $settings->site_name }}"
                        required>
                    <small>{{ __('admin.settings.app.social.redirect_url_help') }}</small>
                </div>

                <div class="form-group col-md-12">
                    <button type="submit" class="px-4 btn btn-primary">{{ __('admin.settings.app.social.save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- <script>
    let sendmail = document.querySelector('#sendmail');
    let smtp = document.querySelector('#smtp');
    let smtptext = document.querySelectorAll('.smtp');
    //console.log(sendmail);
    sendmail.addEventListener('click', sortform);
    smtp.addEventListener('click', sortform);
    
    function sortform(){
        if (sendmail.checked) {
            smtptext.forEach(element => {
                element.classList.add('d-none');
                element.removeAttribute('required','');
            });
        }
        if (smtp.checked) {
            smtptext.forEach(smtps => {
                smtps.classList.remove('d-none');
                smtps.setAttribute('required','');
            });
        }  
    }
    
</script> --}}
