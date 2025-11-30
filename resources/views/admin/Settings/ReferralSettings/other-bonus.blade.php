<div>
    <form method="post" action="javascript:void(0)" id="bonusform">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-2 col-md-6">
                <h5 class="">{{ __('admin.settings.bonus.registration_bonus') }}({{ $settings->currency }})</h5>
                <input type="text" class="form-control  " name="signup_bonus" value="{{ $settings->signup_bonus }}"
                    required>
                <small class="">{{ __('admin.settings.bonus.registration_bonus_description') }}</small>
            </div>
            <div class="mb-2 col-md-6">
                <h5 class="">{{ __('admin.settings.bonus.deposit_bonus') }}</h5>
                <input type="text" class="form-control  " name="deposit_bonus" value="{{ $settings->deposit_bonus }}"
                    required>
                <small class="">{{ __('admin.settings.bonus.deposit_bonus_description') }}</small>
            </div>
            <div class="mb-2 col-md-12">
                <input type="submit" class="px-5 btn btn-primary btn-lg" value="{{ __('admin.settings.common.update_button') }}">
                <input type="hidden" name="id" value="1">
            </div>
        </div>
    </form>
</div>
