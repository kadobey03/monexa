# User Import API Endpoints

Bu belgede, users tablosu için hazırlanan import endpoint'lerinin kullanımı açıklanmaktadır.

## Endpoints

### 1. Tekil User Import
**Endpoint:** `POST /api/import/users`

**Authentication:** Bearer Token gerekli

**İstek Parametreleri:**

| Alan | Tip | Zorunlu | Açıklama |
|------|-----|---------|----------|
| email | string | Evet | Benzersiz email adresi |
| password | string | Evet | Minimum 6 karakter |
| first_name | string | Evet | İsim (maksimum 255 karakter) |
| last_name | string | Hayır | Soyisim (maksimum 255 karakter) |
| phone | string | Hayır | Telefon numarası (maksimum 20 karakter) |
| fa2 | boolean | Hayır | İki faktörlü doğrulama |
| age | integer | Hayır | Yaş (18-120 arası) |
| additional_info | string | Hayır | Ek bilgiler (maksimum 1000 karakter) |
| country | string | Hayır | Ülke (maksimum 100 karakter) |
| region | string | Hayır | Bölge (maksimum 100 karakter) |
| city | string | Hayır | Şehir (maksimum 100 karakter) |
| address | string | Hayır | Adres (maksimum 255 karakter) |
| zip_code | string | Hayır | Posta kodu (maksimum 20 karakter) |
| utm_source | string | Hayır | UTM kaynak (maksimum 100 karakter) |
| utm_medium | string | Hayır | UTM medium (maksimum 100 karakter) |
| utm_campaign | string | Hayır | UTM kampanya (maksimum 100 karakter) |
| utm_content | string | Hayır | UTM içerik (maksimum 255 karakter) |
| utm_term | string | Hayır | UTM term (maksimum 100 karakter) |
| comment | string | Hayır | Yorum (maksimum 1000 karakter) |
| domain | string | Hayır | Domain (maksimum 255 karakter) |

**Örnek İstek:**

```bash
curl --location 'https://yourdomain.com/api/import/users' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer YOUR_API_TOKEN' \
--data-raw '{
    "email": "example@test.com",
    "password": "secret123",
    "first_name": "John",
    "last_name": "Doe",
    "phone": "+1234567890",
    "fa2": false,
    "age": null,
    "additional_info": "Some additional info",
    "country": "US",
    "region": "CA",
    "city": "Los Angeles",
    "address": "123 Main St",
    "zip_code": "90001",
    "utm_source": "google",
    "utm_medium": "cpc",
    "utm_campaign": "campaign_name",
    "utm_content": "ad_content",
    "utm_term": "keyword",
    "comment": "This is a comment",
    "domain": "example.com"
}'
```

**Başarılı Yanıt (201):**

```json
{
    "success": true,
    "message": "User imported successfully",
    "data": {
        "user_id": 123,
        "email": "example@test.com",
        "username": "example",
        "name": "John Doe",
        "lead_score": 45,
        "ref_link": "https://yourdomain.com/ref/example",
        "created_at": "2025-10-28T09:30:00.000Z"
    }
}
```

**Hata Yanıtları:**

**422 - Validation Hatası:**
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 6 characters."]
    }
}
```

**500 - Sunucu Hatası:**
```json
{
    "success": false,
    "message": "User import failed",
    "error": "Database connection failed"
}
```

### 2. Toplu User Import
**Endpoint:** `POST /api/import/users/bulk`

**Authentication:** Bearer Token gerekli

**İstek Parametreleri:**

| Alan | Tip | Zorunlu | Açıklama |
|------|-----|---------|----------|
| users | array | Evet | User objelerinin array'i (maksimum 100 user) |
| users.*.email | string | Evet | Her user için benzersiz email |
| users.*.password | string | Evet | Her user için minimum 6 karakter |
| users.*.first_name | string | Evet | Her user için isim |
| users.*.last_name | string | Hayır | Her user için soyisim |
| users.*.phone | string | Hayır | Her user için telefon |
| users.*.country | string | Hayır | Her user için ülke |

**Örnek İstek:**

```bash
curl --location 'https://yourdomain.com/api/import/users/bulk' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer YOUR_API_TOKEN' \
--data-raw '{
    "users": [
        {
            "email": "user1@test.com",
            "password": "password123",
            "first_name": "User",
            "last_name": "One",
            "phone": "+1111111111",
            "country": "US"
        },
        {
            "email": "user2@test.com",
            "password": "password456",
            "first_name": "User",
            "last_name": "Two",
            "phone": "+2222222222",
            "country": "TR"
        }
    ]
}'
```

**Başarılı Yanıt (200):**

```json
{
    "success": true,
    "message": "Bulk import completed",
    "results": {
        "success": [
            {
                "index": 0,
                "user_id": 124,
                "email": "user1@test.com"
            }
        ],
        "failed": [
            {
                "index": 1,
                "email": "user2@test.com",
                "reason": "Validation failed"
            }
        ],
        "duplicates": []
    },
    "summary": {
        "total": 2,
        "successful": 1,
        "failed": 1,
        "duplicates": 0
    }
}
```

## Önemli Notlar

1. **Authentication:** Tüm endpoint'ler Bearer token ile korunmaktadır.
2. **Username:** Email adresinden otomatik olarak unique username oluşturulur.
3. **Lead Score:** User oluşturulduktan sonra otomatik olarak lead score hesaplanır.
4. **Referral Link:** Settings'de site_address varsa otomatik referral linki oluşturulur.
5. **Email Verification:** Tüm import edilen user'lar otomatik olarak verified olarak işaretlenir.
6. **UTM Tracking:** UTM parametreleri lead_source alanında birleştirilerek saklanır.
7. **Duplicate Control:** Email bazında duplicate kontrolü yapılır.
8. **Bulk Import Limit:** Tek seferde maksimum 100 user import edilebilir.

## Hata Kodları

- **200:** Başarılı (Bulk import)
- **201:** Başarılı oluşturuldu (Tekil import)
- **422:** Validation hatası
- **500:** Sunucu hatası

## Test Etme

API token'ınızı alarak yukarıdaki cURL komutlarını kullanabilirsiniz. Test için önce tekil import'u deneyip, ardından bulk import'u test edebilirsiniz.