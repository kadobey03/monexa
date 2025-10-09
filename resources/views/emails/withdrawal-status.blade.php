{{-- blade-formatter-disable --}}
@component('mail::message')
# Para Çekme Talebi - {{$foramin  ? 'İdari İnceleme Gerekli' : 'Fon Transfer Güncellemesi'}}

@if ($foramin)
## İdari Uyarı: Para Çekme Talebi Beklemede

Sayın Yönetici,

Bir para çekme talebi gönderildi ve inceleme ve işleme için acil dikkat gerektiriyor.

**Para Çekme Talebi Detayları:**
- **Müşteri:** {{$user->name}}
- **Miktar:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **Talep Tarihi:** {{now()->format('F j, Y \a\t g:i A')}}
- **Durum:** İdari İnceleme Beklemede
- **Referans ID:** #{{$withdrawal->id ?? 'WDR'.time()}}

**Gerekli Eylem:** Lütfen müşterinin hesap durumunu inceleyin, uyumluluk gereksinimlerini doğrulayın ve yönetici panosu aracılığıyla para çekme talebini işleyin.

@component('mail::button', ['url' => config('app.url').'/admin/withdrawals'])
Para Çekme Talebini İncele
@endcomponent

@component('mail::panel')
**Uyumluluk Kontrolü:** İşlemeden önce tüm KYC/AML gereksinimlerinin karşılandığından ve hesap doğrulamasının tamamlandığından emin olun.
@endcomponent

@else
## Sayın {{$user->name}},

@if ($withdrawal->status == 'Processed')
**Para çekme işleminiz başarıyla işlendi! 🎉**

Para çekme talebinizin onaylandığını ve işlendiğini doğrulamaktan memnuniyet duyuyoruz. Fonlar şimdi belirlenen hesabınıza gönderiliyor.

**İşlem Özeti:**
- **Miktar:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **İşleme Tarihi:** {{now()->format('F j, Y \a\t g:i A')}}
- **Durum:** Başarıyla İşlendi
- **Referans ID:** #{{$withdrawal->id ?? 'WDR'.time()}}

@component('mail::panel', ['color' => 'success'])
**Fon Transfer Tamamlandı:** Para çekme işleminiz kayıtlı hesabınıza gönderildi. Bankanıza veya ödeme yöntemine bağlı olarak, fonlar 1-5 iş günü içinde görünmelidir.
@endcomponent

**Bekleyebileceğiniz:**
- **Banka Transferleri:** 2-5 iş günü
- **Dijital Cüzdanlar:** 24 saat içinde
- **Kripto Para:** 1-3 ağ onayı

@component('mail::button', ['url' => config('app.url').'/dashboard/transactions'])
İşlem Geçmişini Görüntüle
@endcomponent

**Portföyünüzü Büyütmeye Devam Edin:**
- Bileşik büyüme için karlarınızı yeniden yatırım yapın
- Kopya Ticaret fırsatlarımızı keşfedin
- Premium yatırım stratejilerine erişin

@else
**Para çekme talebiniz işleniyor - Sabrınız için teşekkür ederiz**

Para çekme talebinizi başarıyla aldık ve finansal operasyon ekibimiz şu anda işleminizi inceliyor ve işliyor.

**İşleme Durumu:**
- **Miktar:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **Durum:** İnceleme ve İşleme Altında
- **Referans ID:** #{{$withdrawal->id ?? 'WDR'.time()}}
- **Gönderildi:** {{now()->format('F j, Y \a\t g:i A')}}

@component('mail::panel')
**İşleme Zaman Çizelgesi:** Para çekme talepleri genellikle 1-3 iş günü içinde işlenir. Ekibimiz fonlarınızın güvenli ve emniyetli bir şekilde transfer edilmesini sağlamak için kapsamlı güvenlik kontrolleri yapar.
@endcomponent

**Güvenlik Doğrulama Süreci:**
✅ Hesap doğrulama ve uyumluluk kontrolü<br>
✅ Dolandırıcılık karşıtı ve güvenlik taraması<br>
🔄 **Şu anda para çekmenizi işliyor**<br>
⏳ Nihai onay ve fon transferi

Para çekme onaylandıktan ve fonlar hesabınıza transfer edildikten sonra anında bir bildirim alacaksınız.

@component('mail::button', ['url' => config('app.url').'/dashboard/withdrawals'])
Para Çekme Durumunu Takip Et
@endcomponent

@endif
@endif

---

**Önemli Güvenlik Bilgileri:**

@component('mail::panel', ['color' => 'warning'])
**Güvenlik Hatırlatma:** Korumanız için, giriş kimlik bilgilerinizi asla e-posta yoluyla sormayacağız. Bu para çekmeyi siz talep etmediyseniz, lütfen güvenlik ekibimizle hemen iletişime geçin.
@endcomponent

**Yardıma İhtiyacınız Var mı?**
Özel finansal operasyon ekibimiz para çekmenizle ilgili sorularınızda size yardımcı olmak için hazır.

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
Destek Ekibiyle İletişime Geçin
@endcomponent

**Hızlı Destek Seçenekleri:**
- 7/24 Canlı Sohbet Desteği
- Doğrudan E-posta: {{$settings->contact_email}}
- Telefon: İş saatleri boyunca mevcut

Saygılarımla,<br>
**{{config('app.name')}} Finansal Operasyon Ekibi**<br>
*Güvenli. Güvenilir. Güvenilir.*

@component('mail::subcopy')
Bu para çekme bildirimi güvenlik amacıyla gönderildi. {{config('app.name')}} fonlarınızı korumak için endüstri standardı güvenlik protokolleri kullanır. Tüm para çekme talepleri standart doğrulama prosedürlerimize tabidir. Daha fazla bilgi için [Güvenlik Merkezi]({{config('app.url')}}/terms)'mizi ziyaret edin.
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
