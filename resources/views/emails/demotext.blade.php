{{-- blade-formatter-disable --}}
@component('mail::message')

# {{ $demo->sender }}'a hoş geldiniz!
Kayıt işleminiz başarılı ve sizi {{ $demo->sender }} topluluğuna katılmanızdan gerçekten heyecanlıyız! <br>

<p style="font-size:12px">Sistem tarafından oluşturulan şifreniz: <strong>{{ $demo->password }}</strong></p><br>
<p style="font-size:12px">Lütfen bu şifreyi tercih ettiğiniz bir şifreye değiştirin.</p><br>

Herhangi bir yardıma ihtiyacınız olursa, bizimle iletişime geçmekten çekinmeyin <br> {{ $demo->contact_email }} <br><br>

Saygılarımla,<br>
{{ $demo->sender }}.
@endcomponent
{{-- blade-formatter-disable --}}

