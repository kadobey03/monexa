# Admin Panel Kullanım Kılavuzu - Çok Dilli Destek Sistemi

Bu kılavuz, Monexa Finance platformu admin panelinde çok dilli destek sisteminin nasıl kullanılacağını detaylı olarak açıklamaktadır.

## 📋 İçindekiler

- [Admin Panel Erişimi](#admin-panel-erişimi)
- [Ana Dashboard](#ana-dashboard)
- [Çeviri Yönetimi](#çeviri-yönetimi)
- [Dil Yönetimi](#dil-yönetimi)
- [Toplu İşlemler](#toplu-işlemler)
- [Performans İzleme](#performans-izleme)
- [Dışa ve İçe Aktarma](#dışa-ve-içe-aktarma)
- [Sık Kullanılan İşlemler](#sık-kullanılan-işlemler)

---

## 🔐 Admin Panel Erişimi

### Gerekli Yetkiler

Çeviri yönetimi için aşağıdaki yetkilere sahip olmalısınız:

- `translation.view` - Çevirileri görüntüleme
- `translation.create` - Yeni çeviri ekleme  
- `translation.edit` - Çeviri düzenleme
- `translation.delete` - Çeviri silme
- `translation.manage` - Gelişmiş yönetim işlemleri

### Erişim Rotası

Admin panelinde çeviri yönetimine şu rota ile erişebilirsiniz:

```
https://yourdomain.com/admin/dashboard/phrases
```

### Güvenlik

- Admin oturumu gereklidir
- CSRF koruması aktiftir
- Rate limiting uygulanır
- Tüm işlemler log'lanır

---

## 📊 Ana Dashboard

### İstatistik Kartları

Dashboard sayfasında aşağıdaki istatistikleri görebilirsiniz:

1. **Toplam Phrase Sayısı**
   - Sistemde kayıtlı toplam phrase adedi
   - Son 30 günde eklenen yeni phrase'ler

2. **Dil Tamamlanma Oranları**
   - Her dil için completion yüzdesi
   - Eksik çeviriler sayısı

3. **Cache Performansı**
   - Cache hit/miss oranları
   - Ortalama response süresi

4. **Son Aktiviteler**
   - Son eklenen/güncellenen çeviriler
   - Admin aktivite log'ları

### Hızlı Erişim Butonları

- **Yeni Phrase Ekle** - Modal ile hızlı phrase ekleme
- **Toplu İçe Aktar** - Excel/CSV dosyası yükleme
- **Cache Temizle** - Tüm translation cache'i temizleme
- **Performans Raporu** - Detaylı performans analizi

---

## 🌐 Çeviri Yönetimi

### Liste Görünümü

#### Filtreleme Seçenekleri

**Dil Filtresi:**
```
Tüm Diller | Türkçe | Русский | English
```

**Grup Filtresi:**
```
Tüm Gruplar | auth | admin | user | trading | dashboard
```

**Durum Filtresi:**
```
Tümü | Tamamlanmış | Eksik Çeviriler | İnceleme Bekleyenler
```

**Arama Kutusu:**
- Phrase key'lerinde arama
- Çeviri içeriklerinde arama  
- Açıklama alanlarında arama

#### Tablo Sütunları

| Sütun | Açıklama | İşlemler |
|-------|----------|----------|
| **Key** | Phrase anahtarı (`auth.login`) | Sıralama, Arama |
| **Grup** | Phrase grubu (`auth`, `admin`) | Filtreleme |
| **Türkçe** | Türkçe çeviri | Inline düzenleme |
| **Русский** | Rusça çeviri | Inline düzenleme |
| **Durum** | Tamamlanma durumu | Görsel gösterge |
| **Son Güncelleme** | Güncelleme tarihi | Sıralama |
| **İşlemler** | CRUD butonları | Düzenle, Sil |

### Inline Düzenleme

Çevirileri doğrudan tablo üzerinde düzenleyebilirsiniz:

1. **Çeviri hücresine tıklayın** - Input alanı açılır
2. **Çeviriyi düzenleyin** - Real-time karakter sayacı
3. **Enter'a basın** - Otomatik kayıt
4. **Escape'e basın** - Değişiklikleri iptal

#### Klavye Kısayolları

- `Ctrl + S` - Tüm değişiklikleri kaydet
- `Ctrl + Z` - Son işlemi geri al
- `Tab` - Sonraki hücreye geç
- `Shift + Tab` - Önceki hücreye geç

### Yeni Phrase Ekleme

#### Modal Form Alanları

```html
┌─────────────────────────────────────────┐
│  Yeni Phrase Ekle                       │
├─────────────────────────────────────────┤
│  Key: [auth.new_feature               ] │
│  Grup: [Seçiniz ▼]                     │
│  Açıklama: [                          ] │
│         [                              ] │
│  ┌─ Çeviriler ────────────────────────┐ │
│  │ 🇹🇷 Türkçe: [                    ] │ │
│  │ 🇷🇺 Русский: [                   ] │ │
│  │ + Başka Dil Ekle                   │ │
│  └────────────────────────────────────┘ │
│              [İptal] [Kaydet]           │
└─────────────────────────────────────────┘
```

#### Validation Kuralları

- **Key**: Benzersiz olmalı, nokta notasyonu (`group.key`)
- **Grup**: Mevcut gruplardan seçim veya yeni grup
- **Çeviriler**: En az bir dil için çeviri gerekli
- **Karakter Limiti**: 5000 karakter maksimum

### Phrase Düzenleme

#### Detay Sayfası

Phrase'e tıklayarak detay sayfasına erişebilirsiniz:

**Üst Kısım - Meta Bilgiler:**
- Key ve grup bilgisi
- Oluşturma/güncelleme tarihleri
- Kullanım istatistikleri
- Quality score

**Çeviri Sekmeli Interface:**

```
[Türkçe] [Русский] [+ Yeni Dil]

┌─────────────────────────────────────────┐
│ Çeviri: [Giriş Yap                    ] │
│                                         │
│ ☑ İncelenmiş  👤 Admin: john_doe        │
│ 📅 İnceleme: 2024-01-15 10:30          │
│ ⭐ Kalite: ████████ 8.5/10             │
│                                         │
│ 📝 Notlar:                             │
│ [Bu çeviri KYC sürecinde kullanılıyor ] │
└─────────────────────────────────────────┘
```

### Toplu Düzenleme

Birden çok phrase'i aynı anda düzenlemek için:

1. **Checkbox'ları işaretleyin** - Düzenlenecek phrase'leri seçin
2. **Toplu İşlemler menüsü** - Sayfanın üstünde belirir
3. **İşlem seçin**:
   - Toplu düzenleme modal'ı
   - Grup değiştirme
   - Durum güncelleme
   - Silme

---

## 🗣️ Dil Yönetimi

### Aktif Diller

Sistemde aktif olan dilleri yönetebilirsiniz:

#### Dil Listesi

| Dil | Kod | Flag | Tamamlanma | Durum | İşlemler |
|-----|-----|------|-----------|--------|----------|
| Türkçe | tr | 🇹🇷 | 100% | ✅ Aktif | Düzenle |
| Русский | ru | 🇷🇺 | 85% | ✅ Aktif | Düzenle |
| English | en | 🇬🇧 | 0% | ❌ Pasif | Aktifleştir |

#### Yeni Dil Ekleme

```html
┌─────────────────────────────────────────┐
│  Yeni Dil Ekle                         │
├─────────────────────────────────────────┤
│  Dil Kodu: [es] (ISO 639-1)           │
│  Dil Adı: [Español]                   │  
│  Flag: [🇪🇸] veya [es]                 │
│  Durum: ☑ Aktif                       │
│                                         │
│  ⚠️  Not: Yeni dil eklendikten sonra   │
│     tüm phrase'ler için çeviri         │
│     eklemeniz gerekecek.               │
│              [İptal] [Kaydet]           │
└─────────────────────────────────────────┘
```

### Completion İstatistikleri

Her dil için detaylı tamamlanma raporu:

```
📊 Türkçe (tr) - %100 Tamamlandı
├── 🔵 Tamamlanan: 150/150
├── 🟡 İnceleme Bekleyen: 0
├── 🔴 Eksik: 0  
└── ⚡ Son Güncelleme: 2 saat önce

📊 Русский (ru) - %85 Tamamlandı  
├── 🔵 Tamamlanan: 128/150
├── 🟡 İnceleme Bekleyen: 5
├── 🔴 Eksik: 17
└── ⚡ Son Güncelleme: 1 gün önce
```

---

## ⚡ Toplu İşlemler

### Bulk Update

Seçili phrase'ler için toplu işlemler:

#### Grup Değiştirme
```
Seçili 15 phrase → Grup: [admin] → [Uygula]
```

#### Status Güncelleme
```
Seçili phrase'ler → Durum: [İncelenmiş] → [Uygula]
```

#### Toplu Silme
```
⚠️  DİKKAT: 8 phrase kalıcı olarak silinecek!
[x] Bu işlemi onaylıyorum → [Sil]
```

### Import/Export

#### Excel İçe Aktarma

**Desteklenen Formatlar:** `.xlsx`, `.xls`, `.csv`

**Excel Template:**
```
| key | group | description | tr | ru | en |
|-----|-------|-------------|----|----|-----|
| auth.welcome | auth | Hoş geldin mesajı | Hoş geldiniz | Добро пожаловать | Welcome |
| user.profile | user | Profil sayfası | Profil | Профиль | Profile |
```

**İçe Aktarma Adımları:**

1. **Dosya Seçimi**
   ```html
   📁 Dosya Seç: [                    ] [Gözat]
   Format: Excel/CSV ▼
   ```

2. **Mapping Ayarları**
   ```
   Excel Sütunu → Database Alanı
   A (key) → phrase.key
   B (group) → phrase.group  
   C (description) → phrase.description
   D (tr) → translation.tr
   E (ru) → translation.ru
   ```

3. **Preview & Import**
   ```
   ✅ 45 yeni phrase eklenecek
   ⚠️  12 mevcut phrase güncellenecek  
   ❌ 3 hatalı satır atlandı
   
   [Önizlemeyi İndir] [İçe Aktar]
   ```

#### Dışa Aktarma

**Export Seçenekleri:**

```html
┌─────────────────────────────────────────┐
│  Dışa Aktarma Ayarları                 │
├─────────────────────────────────────────┤
│  Format: [Excel ▼] [CSV] [JSON]        │
│  Diller: ☑ tr ☑ ru ☐ en              │
│  Gruplar: ☑ Tümü                      │
│          ☐ auth ☐ admin ☐ user         │
│  Durum: ☑ Tamamlanan ☑ Eksik          │
│                                         │
│  📧 Email Gönder: ☐                   │
│     [admin@monexa.com              ]   │
│              [İptal] [Dışa Aktar]      │
└─────────────────────────────────────────┘
```

---

## 📈 Performans İzleme

### Cache Dashboard

Real-time cache metrikleri:

```
🚀 Cache Performansı (Son 24 Saat)
├── Hit Rate: ████████████ 87.5%
├── Total Hits: 12,450
├── Total Misses: 1,750  
├── Memory Usage: 15.2 MB / 64 MB
└── Avg Response: 2.3ms

🎯 Top Cached Keys:
1. translations:tr:auth (1,250 hits)
2. translations:ru:admin (980 hits)  
3. translations:tr:user (750 hits)

⚡ Cache Operations:
[Tümünü Temizle] [Auth Grup] [Admin Grup] [Isınma]
```

### Query Performance

Database sorgu performansı:

```
📊 Database Performansı
├── Avg Query Time: 15.2ms
├── Slow Queries: 3 (>100ms)
├── N+1 Queries: 0 ✅
└── Connection Pool: 8/10 aktif

🐌 Yavaş Sorgular:
1. phrase_search_with_translation: 156ms
2. completion_stats_by_language: 124ms
3. bulk_translation_update: 108ms

💡 Öneriler:
- phrase_translations tablosuna (phrase_id, language_id) index ekleyin
- Cache TTL'yi 3600s'ye artırın  
- Connection pool size'ı 15'e çıkarın
```

### Performance Reports

Haftalık/aylık performans raporları:

```
📋 Performans Raporu - Ocak 2024

Translation Usage:
├── Total Requests: 145,230 (+12%)
├── Unique Keys: 1,850 (+150)
├── Languages: tr (65%), ru (30%), en (5%)
└── Peak Hour: 14:00-15:00 (2,150 req/h)

Cache Efficiency:  
├── Hit Rate: 89.2% (+2.1%)
├── Memory Usage: Avg 18.5 MB
├── Invalidations: 450 (-15%)
└── Warm-up Time: 2.3s (-0.5s)

Database Health:
├── Query Count: 58,920 (-8%)
├── Avg Response: 12.8ms (-2.1ms)  
├── Connection Issues: 0 ✅
└── Storage Growth: +150 MB

[PDF İndir] [Excel İndir] [Email Gönder]
```

---

## 📥📤 Dışa ve İçe Aktarma

### Automated Backups

Otomatik yedekleme ayarları:

```html
⚙️  Otomatik Yedekleme Ayarları

Sıklık: [Günlük ▼] [Haftalık] [Aylık]
Format: [JSON ▼] [Excel] [CSV]  
Konum: [/backups/translations/]
Retention: [30 gün] 

Email Bildirimleri:
☑ Başarılı yedekleme
☑ Yedekleme hatası
☐ Weekly summary

[Şimdi Yedekle] [Ayarları Kaydet]
```

### Restore İşlemleri

Yedek dosyadan geri yükleme:

```html
⚠️  Geri Yükleme İşlemi

Yedek Dosya: [backup_20240115.json] [Seç]

Geri Yükleme Seçenekleri:
☐ Mevcut verileri sil (Tam geri yükleme)
☑ Sadece eksik phrase'leri ekle  
☐ Çakışanları güncelle

Önizleme:
✅ 45 yeni phrase eklenecek
⚠️  12 phrase güncellenecek
❌ 3 çakışma algılandı

[Önizleme] [Geri Yükle]
```

### Migration Tools

Eski sistemden geçiş araçları:

```bash
# Lang dosyalarından database'e aktarım
docker-compose exec app-monexa php artisan translation:migrate-files

# Eski format çevirilerini güncelle  
docker-compose exec app-monexa php artisan translation:update-format

# Duplicate'ları temizle
docker-compose exec app-monexa php artisan translation:cleanup-duplicates
```

---

## 🔧 Sık Kullanılan İşlemler

### Yeni Feature İçin Çeviri Ekleme

**Senaryo:** Yeni bir özellik geliştirildi ve çevirileri eklenmeli.

1. **Phrase'leri Belirle**
   ```
   feature.new_trading.title
   feature.new_trading.description  
   feature.new_trading.button_start
   feature.new_trading.success_message
   ```

2. **Toplu Ekleme (Excel)**
   ```csv
   key,group,description,tr,ru
   feature.new_trading.title,trading,Yeni trading özelliği başlığı,Yeni Trading,Новый Трейдинг
   feature.new_trading.description,trading,Açıklama metni,Bu özellik ile...,Эта функция позволяет...
   ```

3. **Cache Güncelleme**
   ```
   Admin Panel → Performance → Cache → [Trading Grup Temizle]
   ```

### Çeviri Kalitesi İyileştirme

**İnceleme Süreci:**

1. **Düşük Kalite Skorlu Çevirileri Filtrele**
   ```
   Filtre: Quality Score < 7.0
   Sonuç: 15 çeviri bulundu
   ```

2. **Batch Review**
   ```
   Seçili çevirileri işaretle → Toplu İşlemler → Review For Quality
   ```

3. **Native Speaker Review**
   ```
   Assign to: translator_native_ru
   Due date: +3 days
   Priority: High
   ```

### Performance Sorunları Çözme

**Yavaş Loading Problemi:**

1. **Diagnosis**
   ```
   Performance Tab → Query Analysis
   Slow Query Detected: translation_search (450ms)
   ```

2. **Optimization**
   ```
   Database → Add Index:
   ALTER TABLE phrase_translations 
   ADD INDEX idx_phrase_lang (phrase_id, language_id);
   ```

3. **Cache Strategy**
   ```
   Cache Settings → Increase TTL: 3600s → 7200s
   Warm Cache → All Active Languages
   ```

### Bulk Operations

**Scenario: Tüm 'admin' Grubunu 'backend' Olarak Değiştir**

1. **Filter & Select**
   ```
   Grup: admin → 150 sonuç
   Select All → Toplu İşlemler
   ```

2. **Bulk Group Change**
   ```
   Yeni Grup: backend
   ⚠️  150 phrase etkilenecek
   Backup: ☑ İşlem öncesi yedek al
   ```

3. **Verification**
   ```
   İşlem tamamlandı ✅
   Log ID: #TXN_20240115_001
   Backup: backup_pre_group_change.json
   ```

---

## 🆘 Sorun Giderme

### Yaygın Hatalar

#### "Translation Not Found" Hatası

```
❌ Hata: Translation key 'auth.new_button' bulunamadı

🔧 Çözüm:
1. Admin Panel → Phrases → Arama: "auth.new_button" 
2. Bulunamadıysa: [Yeni Phrase Ekle]
3. Key: auth.new_button, Grup: auth
4. Cache temizle: [Auth Grup Cache]
```

#### Yavaş Yüklenme Problemi

```
⚠️  Problem: Admin panel yavaş açılıyor (>5s)

🔧 Çözümler:
1. Cache Status kontrol et
2. Database connection sayısı: [8/10] ✅  
3. Redis memory: [45 MB / 64 MB] ✅
4. Query log: 3 slow query var ⚠️
   → [Query Optimization] çalıştır
```

#### Import Hatası

```
❌ Excel içe aktarma başarısız (Row 15: Invalid key format)

🔧 Çözüm:  
1. Template indir: [Excel Template]
2. Key format: group.subkey (nokta gerekli)
3. Hatalı: authlogin → Doğru: auth.login
4. Re-import: [Dosyayı Tekrar Yükle]
```

### Emergency Procedures

#### Translation Sistemi Çöktü

```
🚨 ACIL DURUM: Translation servisi çalışmıyor

1. Cache Status: [Kontrol Et]
   ├── Redis connection: ❌ FAILED
   └── Fallback to Database: ✅ ACTIVE

2. Immediate Action:
   └── Container restart: 
       docker-compose restart redis-monexa

3. Verification:
   ├── Cache test: ✅ OK  
   ├── Translation test: ✅ OK
   └── Performance test: ✅ Normal

4. Root Cause Analysis:
   └── Check logs: /var/log/redis/redis.log
```

#### Database Corruption

```
🚨 ACIL: Phrase tablosunda veri kaybı algılandı

1. Stop Application:
   └── maintenance:on

2. Database Backup:
   └── mysqldump translations_* > emergency_backup.sql

3. Restore from Latest Backup:
   └── mysql < backup_20240114_daily.sql

4. Data Verification:
   ├── Phrase count: 150 ✅
   ├── Translation count: 280 ✅  
   └── Cache rebuild: ✅

5. Application Start:
   └── maintenance:off
```

---

## 📞 Destek ve İletişim

### Teknik Destek

- **Email**: tech-support@monexa.com
- **Ticket System**: /admin/support/tickets
- **Emergency**: +90 XXX XXX XX XX

### Dokümantasyon

- **Developer API**: `/docs/API-Documentation.md`
- **System Architecture**: `/docs/Architecture.md`
- **Troubleshooting**: `/docs/Troubleshooting.md`

### Training Resources

- **Video Tutorials**: [Internal Training Platform]
- **Best Practices Guide**: [Wiki Link]
- **Regular Training Sessions**: Her Pazartesi 14:00

---

Bu kullanım kılavuzu, admin panelinin tüm özelliklerini kapsamaktadır. Herhangi bir sorun yaşadığınızda önce bu kılavuzu kontrol edin, ardından teknik destek ekibiyle iletişime geçin.