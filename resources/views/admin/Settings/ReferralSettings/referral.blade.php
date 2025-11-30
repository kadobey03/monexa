<div>
    <form method="post" action="javascript:void(0)" id="refform">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-2 col-md-6">
                <h5 class="">{{ __('admin.settings.referral.direct_commission') }}</h5>
                <input type="text" class="form-control  " name="ref_commission"
                    value="{{ $settings->referral_commission }}" required>
            </div>
            <div class="mb-2 col-md-6">
                <h5 class="">{{ __('admin.settings.referral.indirect_commission_1') }}</h5>
                <input type="text" class="form-control  " name="ref_commission1"
                    value="{{ $settings->referral_commission1 }}" required>
            </div>
            <div class="mb-2 col-md-6">
                <h5 class="">{{ __('admin.settings.referral.indirect_commission_2') }}</h5>
                <input type="text" class="form-control  " name="ref_commission2"
                    value="{{ $settings->referral_commission2 }}" required>
            </div>
            <div class="mb-2 col-md-6">
                <h5 class="">{{ __('admin.settings.referral.indirect_commission_3') }}</h5>
                <input type="text" class="form-control  " name="ref_commission3"
                    value="{{ $settings->referral_commission3 }}" required>
            </div>
            <div class="mb-2 col-md-6">
                <h5 class="">{{ __('admin.settings.referral.indirect_commission_4') }}</h5>
                <input type="text" class="form-control  " name="ref_commission4"
                    value="{{ $settings->referral_commission4 }}" required>
            </div>
            <div class="mb-2 col-md-6">
                <h5 class="">{{ __('admin.settings.referral.indirect_commission_5') }}</h5>
                <input type="text" class="form-control   " name="ref_commission5"
                    value="{{ $settings->referral_commission5 }}" required>
            </div>
            <div class="mb-2 col-md-12">
                <input type="submit" class="px-5 btn btn-primary btn-lg" value="{{ __('admin.settings.common.update_button') }}">
                <input type="hidden" name="id" value="1">
            </div>
        </div>
    </form>
</div>
