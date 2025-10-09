@component('mail::message')
# Yatırım Planı Tamamlandı

Sayın {{ $name }},

**{{ $planName }}** planındaki yatırımınız başarıyla tamamlandı.

## Yatırım Detayları
- **Yatırım Miktarı:** {{ $currency }}{{ number_format($amount, 2) }}
- **Kazanılan Toplam Kar:** {{ $currency }}{{ number_format($profit, 2) }}
- **Toplam Getiri:** {{ $currency }}{{ number_format($totalReturn, 2) }}
- **Başlangıç Tarihi:** {{ $startDate }}
- **Bitiş Tarihi:** {{ $endDate }}

@if($profit > 0)
Başarılı yatırımınız için tebrikler! Karlar hesap bakiyenize yatırıldı.
@else
Yatırımınız tamamlandı. Lütfen en son bakiye için hesabınızı kontrol edin.
@endif

Başka bir planla yatırım yapabilir veya hesap panonuzdan fonlarınızı çekebilirsiniz.

@component('mail::button', ['url' => $siteUrl . '/login'])
Hesaba Giriş Yap
@endcomponent

Yatırım ihtiyaçlarınız için {{ $siteName }}'i seçtiğiniz için teşekkür ederiz.

Saygılarımla,<br>
{{ $siteName }} Ekibi
@endcomponent
