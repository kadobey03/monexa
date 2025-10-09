{{-- blade-formatter-disable --}}
@component('mail::message')
# {{ $salutaion ? $salutaion : "Önemli Güncelleme" }} {{ $recipient}},

@if ($attachment != null)
    @component('mail::panel')
    **Eklenen Belge:** Bu bildirimle ilgili ek detaylar için lütfen eklenen belgeyi inceleyin.
    @endcomponent
    <div style="text-align: center; margin: 24px 0;">
        <img src="{{ $message->embed(asset('storage/'. $attachment)) }}" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);" alt="Attachment">
    </div>
@endif

## Hesap Bildirimi

{!! $body !!}

---

### 📞 **Yardıma İhtiyacınız Var mı?**

Bu bildirimle ilgili sorularınız varsa veya yatırım ile ilgili konularda açıklama ihtiyacınız varsa, profesyonel destek ekibimiz burada yardımcı olmaya hazır.

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
Destek Ekibiyle İletişime Geçin
@endcomponent

**Hızlı Destek Seçenekleri:**
- **7/24 Canlı Sohbet:** Panonuz aracılığıyla anında yardım
- **E-posta Desteği:** {{$settings->contact_email}}
- **Telefon Desteği:** İş saatleri boyunca mevcut
- **Yatırım Danışmanlığı:** Uzmanlarımızla danışmanlık planlayın

### 🔔 **Bildirim Tercihleri**

Bildirim tercihlerinizi yönetebilir ve hesap ayarlarınız üzerinden hangi güncellemeleri almak istediğinizi seçebilirsiniz.

@component('mail::button', ['url' => config('app.url').'/dashboard/settings'])
Bildirimleri Yönet
@endcomponent

### 📊 **Bilgilendirilmiş Kalın**

**Yatırım yolculuğunuzu takip edin:**
- Portföy performans güncellemeleri
- Piyasa içgörüleri ve analizleri
- Ticaret fırsatları ve uyarıları
- Hesap güvenliği bildirimleri
- Platform güncellemeleri ve yeni özellikler

---

### 🛡️ **Güvenlik Bildirimi**

@component('mail::panel', ['color' => 'warning'])
**Önemli:** {{config('app.name')}} hiçbir zaman giriş kimlik bilgilerinizi, şifrelerinizi veya hassas hesap bilgilerinizi e-posta yoluyla sormayacaktır. Şüpheli iletişimler alırsanız, lütfen güvenlik ekibimizle hemen iletişime geçin.
@endcomponent

**Saygılarımla,**<br>
**{{config('app.name')}} Ekibi**<br>
*Güvenilir Yatırım Ortağınız*

---

@component('mail::subcopy')
Bu bildirim, {{config('app.name')}} hesap iletişimlerinizin bir parçası olarak size gönderildi. Bu e-postayı yanlışlıkla aldığınızı düşünüyorsanız veya hesap güvenliğiniz hakkında endişeleriniz varsa, lütfen destek ekibimizle hemen iletişime geçin.

İletişim tercihlerinizi güncelleyebilir veya belirli bildirimlerden çıkabilirsiniz [Hesap Ayarları]({{config('app.url')}}/dashboard/settings) aracılığıyla. Önemli güvenlik ve hesap ile ilgili bildirimler için, bildirimleri etkin tutmanızı öneririz.

© {{date('Y')}} {{$settings->site_name}}. Tüm hakları saklıdır. | [Gizlilik Politikası]({{$settings->site_address}}/privacy) | [Hizmet Şartları]({{$settings->site_address}}/terms)
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
