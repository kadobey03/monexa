{{-- blade-formatter-disable --}}
@component('mail::message')
# Para Yatırma Onayı - {{$foramin  ? 'Yönetici Bildirimi' : 'Ticaret Yolculuğunuza Hoş Geldiniz'}}

@if ($foramin)
## İdari Uyarı: Yeni Para Yatırma Alındı

Sayın Yönetici,

Yeni bir para yatırmanın başarıyla alındığını bildirmekten memnuniyet duyuyoruz:

**Para Yatırma Detayları:**
- **Müşteri:** {{$user->name}}
- **Miktar:** {{$user->currency}}{{number_format($deposit->amount, 2)}}
- **Durum:** {{$deposit->status}}
- **Tarih:** {{now()->format('F j, Y \a\t g:i A')}}

@if($deposit->status != "Processed")
**Eylem Gerekli:** Lütfen yönetici panosu aracılığıyla bu para yatırmayı inceleyin ve işleyin.

@component('mail::button', ['url' => config('app.url').'/admin/dashboard'])
Para Yatırmayı İşle
@endcomponent
@else
Bu para yatırma otomatik olarak işlendi ve müşterinin hesabına yatırıldı.
@endif

@else
## Sayın {{$user->name}},

@if ($deposit->status == 'Processed')
**Tebrikler! Para yatırmanız başarıyla işlendi.**

**{{$user->currency}}{{number_format($deposit->amount, 2)}}** tutarındaki para yatırmanızın alındığını ve işlendiğini doğrulamaktan memnuniyet duyuyoruz. Ticaret hesabınıza tam tutar yatırıldı.

**Sonraki Ne?**
- Fonlarınız artık ticaret için kullanılabilir
- Gelişmiş ticaret araçlarımızı ve analizlerimizi keşfedin
- Bugün yatırım portföyünüzü oluşturmaya başlayın

@component('mail::button', ['url' => config('app.url').'/dashboard'])
Şimdi Ticaret Başlat
@endcomponent

**Yatırım Fırsatları Bekliyor:**
- Kopya Ticaret özelliğimizle başarılı tüccarları kopyalayın
- Gerçek zamanlı piyasa verilerine ve gelişmiş grafiklere erişin
- Algoritmik ticaret araçlarımızdan yararlanın

@else
**Para yatırmanız işleniyor - Bizi seçtiğiniz için teşekkür ederiz!**

**{{$user->currency}}{{number_format($deposit->amount, 2)}}** tutarındaki para yatırmanızı başarıyla aldık. Finans ekibimiz şu anda işleminizi inceliyor ve doğruluyor.

**İşleme Durumu:** İnceleme Altında
**Beklenen İşleme Süresi:** 1-3 iş saati


Para yatırmanız doğrulandıktan ve ticaret hesabınıza yatırıldıktan sonra anında bir bildirim alacaksınız.

@component('mail::panel')
**Güvenlik Bildirimi:** Fonlarınızın işleme süresi boyunca güvenli ve güvende olmasını sağlamak için banka düzeyinde güvenlik protokolleri kullanıyoruz.
@endcomponent

@endif
@endif

---

**Yardıma İhtiyacınız Var mı?**
Herhangi bir sorunuzda size yardımcı olmak için özel destek ekibimiz 7/24 hazır.

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
Desteğe Başvurun
@endcomponent

Saygılarımla,<br>
**{{config('app.name')}} Ekibi**<br>
*Güvenilir Ticaret Ortağınız*

@component('mail::subcopy')
Bu, {{config('app.name')}}'dan otomatik bir mesajdır. Güvenlik amacıyla, lütfen bu e-postayı kimseyle paylaşmayın. Bu para yatırmayı başlatmadıysanız, lütfen destek ekibimizle hemen iletişime geçin.
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
