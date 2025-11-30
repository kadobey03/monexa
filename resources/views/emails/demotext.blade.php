{{-- blade-formatter-disable --}}
@component('mail::message')

# {{ __('mail.demo.welcome_title', ['siteName' => $demo->sender]) }}
{{ __('mail.demo.registration_success', ['siteName' => $demo->sender]) }} <br>

<p style="font-size:12px">{{ __('mail.demo.generated_password_label') }} <strong>{{ $demo->password }}</strong></p><br>
<p style="font-size:12px">{{ __('mail.demo.change_password_instruction') }}</p><br>

{{ __('mail.demo.help_contact_message') }} <br> {{ $demo->contact_email }} <br><br>

{{ __('mail.footer.regards') }},<br>
{{ $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}

