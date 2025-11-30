{{-- blade-formatter-disable --}}
@component('mail::message')
#{{ __('mail.security.two_factor_code') }}

{{ __('mail.security.account_verification') }} <br>
{{ __('mail.security.verify_identity') }}:<br>
{{ __('mail.security.two_factor_code') }}: <strong>{!! $demo->message !!}</strong> <br>

{{ __('mail.footer.thanks') }},<br>
{{ $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}
