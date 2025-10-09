{{-- blade-formatter-disable --}}
@component('mail::message')
# {{$settings->site_name}}'a hoş geldiniz, {{$user->name}}!

## Gelişmiş Yatırım Fırsatlarına Geçidiniz

Sayın {{$user->name}},

**{{$settings->site_name}}** ailesine katılmanızdan heyecan duyuyoruz - akıllı yatırımın en son teknolojiyle buluştuğu yer. Finansal büyüme ve portföy çeşitlendirmeye yolculuğunuz bugün başlıyor.

### 🚀 **Bizi Farklı Kılan Nedir**

**{{$settings->site_name}}** sadece bir ticaret platformu değil. Uzun vadeli zenginlik oluşturma konusunda stratejik ortağınızız:

- **Gelişmiş Algoritmik Ticaret** - AI destekli stratejilerden yararlanın
- **Kopya Ticaret Mükemmelliği** - Başarılı tüccarları takip edin ve çoğaltın
- **Çeşitlendirilmiş Yatırım Planları** - Muhafazakardan agresif büyüme seçeneklerine
- **Gerçek Zamanlı Analitikler** - Profesyonel düzey piyasa içgörüleri
- **Risk Yönetimi Araçları** - Yatırımlarınızı koruyun ve optimize edin

### 📈 **Başarıya Sonraki Adımlarınız**

@component('mail::panel')
**Başlamak Basit:**

1. **Profilinizi Tamamlayın** - Gelişmiş güvenlik için hesabınızı doğrulayın
2. **Yatırım Seçeneklerini Keşfedin** - Küratörlüğümüz yatırım planlarını inceleyin
3. **İlk Para Yatırmanızı Yapın** - Rahat olduğunuz bir tutarla başlayın
4. **Stratejinizi Seçin** - Algoritmik ticaret veya kopya ticaret arasından seçin
5. **İzleyin ve Büyütün** - Portföy performansınızı gerçek zamanlı takip edin
@endcomponent

@component('mail::button', ['url' => config('app.url').'/dashboard'])
Panonuza Erişin
@endcomponent

### 💡 **Yatırım Fırsatları Bekliyor**

**Yeni Başlayan Dostu Seçenekler:**
- Düşük riskli yatırım planları sabit getirilerle
- Eğitim kaynakları ve piyasa analizi
- Yeni yatırımcılar için özel destek

**Gelişmiş Ticaret Özellikleri:**
- Başarılı tüccarları otomatik olarak kopyalayın
- Premium piyasa sinyallerine erişim
- Gelişmiş portföy yönetim araçları

### 🛡️ **Güvenliğiniz Önceliğimiz**

Yatırımlarınızın aşağıdakilerle korunduğundan emin olun:
- Banka düzeyinde şifreleme ve güvenlik protokolleri
- Düzenleyici uyumluluk ve şeffaf işlemler
- 7/24 izleme ve dolandırıcılık koruması
- Maksimum güvenlik için ayrılmış müşteri fonları

### 📞 **İhtiyacınız Olduğunda Uzman Desteği**

Profesyonel ekibimiz her adımda size rehberlik etmek için burada:

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
Yatırım Danışmanlarımızla İletişime Geçin
@endcomponent

**Mevcut Destek:**
- 7/24 Müşteri Hizmetleri
- Kişisel Yatırım Danışmanlıkları
- Eğitim Webinarları ve Kaynakları
- Piyasa Analizi ve İçgörüleri

---

### 🎯 **Başlamaya Hazır mısınız?**

Küresel piyasalar asla uyumaz ve fırsatlar da öyle. Aradığınız şey:
- Emeklilik zenginliği oluşturmak
- Pasif gelir üretmek
- Yatırım portföyünüzü çeşitlendirmek
- Gelişmiş ticaret stratejilerini öğrenmek

**{{$settings->site_name}}** finansal hedeflerinize ulaşmanız için gereken araçları, uzmanlığı ve desteği sağlar.

@component('mail::panel', ['color' => 'success'])
**Özel Hoş Geldiniz Teklifi:** Yeni üye olarak, ilk 30 gün boyunca premium piyasa analizimize ücretsiz erişim alacaksınız. Gün birinden itibaren bilinçli yatırım kararları vermeye başlayın!
@endcomponent

Gemiye hoş geldiniz, yatırım başarınız için!

**{{$settings->site_name}} Ekibi**<br>
*Gün Birinden Beri Akıllı Yatırımcıları Güçlendiriyor*

---

@component('mail::subcopy')
**Sorumluluk Reddi:** Tüm yatırımlar risk taşır ve geçmiş performans gelecek sonuçları garanti etmez. Lütfen dahil olan riskleri anladığınızdan emin olun ve gerekirse bağımsız finansal tavsiye almayı düşünün. {{$settings->site_name}} sorumlu yatırım uygulamalarına bağlıdır.

Daha fazla bilgi için [Risk Açıklaması]() sayfamızı ziyaret edin.
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
