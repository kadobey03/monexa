{{-- blade-formatter-disable --}}
@component('mail::message')
#2FA kodu.

Hesabınız kullanılarak geçici bir 2FA kodu isteği yapıldı. <br>
Lütfen aşağıdaki detayları kullanarak kimlik doğrulayın:<br>
2FA kodu: <strong>{!! $demo->message !!}</strong> <br>

Teşekkürler,<br>
{{ $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}
