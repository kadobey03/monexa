<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute kabul edilmelidir.',
    'accepted_if' => ':other :value olduğunda :attribute kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL değil.',
    'after' => ':attribute :date tarihinden sonra olmalı.',
    'after_or_equal' => ':attribute :date tarihinden sonra veya aynı tarihte olmalı.',
    'alpha' => ':attribute sadece harfler içermelidir.',
    'alpha_dash' => ':attribute sadece harfler, sayılar, tireler ve alt çizgiler içermelidir.',
    'alpha_num' => ':attribute sadece harfler ve sayılar içermelidir.',
    'array' => ':attribute bir dizi olmalı.',
    'before' => ':attribute :date tarihinden önce olmalı.',
    'before_or_equal' => ':attribute :date tarihinden önce veya aynı tarihte olmalı.',
    'between' => [
        'numeric' => ':attribute :min ve :max arasında olmalı.',
        'file' => ':attribute :min ve :max kilobayt arasında olmalı.',
        'string' => ':attribute :min ve :max karakter arasında olmalı.',
        'array' => ':attribute :min ve :max öğe arasında olmalı.',
    ],
    'boolean' => ':attribute doğru veya yanlış olmalı.',
    'confirmed' => ':attribute onayı eşleşmiyor.',
    'current_password' => 'Şifre yanlış.',
    'date' => ':attribute geçerli bir tarih değil.',
    'date_equals' => ':attribute :date tarihine eşit olmalı.',
    'date_format' => ':attribute :format formatına uymuyor.',
    'declined' => ':attribute reddedilmelidir.',
    'declined_if' => ':other :value olduğunda :attribute reddedilmelidir.',
    'different' => ':attribute ve :other farklı olmalı.',
    'digits' => ':attribute :digits basamaklı olmalı.',
    'digits_between' => ':attribute :min ve :max basamak arasında olmalı.',
    'dimensions' => ':attribute geçersiz görüntü boyutlarına sahip.',
    'distinct' => ':attribute alanı yinelenen bir değere sahip.',
    'email' => ':attribute geçerli bir e-posta adresi olmalı.',
    'ends_with' => ':attribute şu değerlerden biri ile bitmelidir: :values.',
    'enum' => 'Seçilen :attribute geçersiz.',
    'exists' => 'Seçilen :attribute geçersiz.',
    'file' => ':attribute bir dosya olmalı.',
    'filled' => ':attribute alanı bir değere sahip olmalı.',
    'gt' => [
        'numeric' => ':attribute :value\'den büyük olmalı.',
        'file' => ':attribute :value kilobayttan büyük olmalı.',
        'string' => ':attribute :value karakterden uzun olmalı.',
        'array' => ':attribute :value\'den fazla öğeye sahip olmalı.',
    ],
    'gte' => [
        'numeric' => ':attribute :value\'den büyük veya eşit olmalı.',
        'file' => ':attribute :value kilobayt veya daha büyük olmalı.',
        'string' => ':attribute :value karakter veya daha uzun olmalı.',
        'array' => ':attribute :value öğe veya daha fazlasına sahip olmalı.',
    ],
    'image' => ':attribute bir görüntü olmalı.',
    'in' => 'Seçilen :attribute geçersiz.',
    'in_array' => ':attribute alanı :other içinde mevcut değil.',
    'integer' => ':attribute bir tam sayı olmalı.',
    'ip' => ':attribute geçerli bir IP adresi olmalı.',
    'ipv4' => ':attribute geçerli bir IPv4 adresi olmalı.',
    'ipv6' => ':attribute geçerli bir IPv6 adresi olmalı.',
    'json' => ':attribute geçerli bir JSON dizesi olmalı.',
    'lt' => [
        'numeric' => ':attribute :value\'den küçük olmalı.',
        'file' => ':attribute :value kilobayttan küçük olmalı.',
        'string' => ':attribute :value karakterden kısa olmalı.',
        'array' => ':attribute :value\'den az öğeye sahip olmalı.',
    ],
    'lte' => [
        'numeric' => ':attribute :value\'den küçük veya eşit olmalı.',
        'file' => ':attribute :value kilobayt veya daha küçük olmalı.',
        'string' => ':attribute :value karakter veya daha kısa olmalı.',
        'array' => ':attribute :value öğe veya daha azına sahip olmalı.',
    ],
    'mac_address' => ':attribute geçerli bir MAC adresi olmalı.',
    'max' => [
        'numeric' => ':attribute :max\'ten büyük olmamalı.',
        'file' => ':attribute :max kilobayttan büyük olmamalı.',
        'string' => ':attribute :max karakterden uzun olmamalı.',
        'array' => ':attribute :max öğeden fazla olmamalı.',
    ],
    'mimes' => ':attribute şu dosya türlerinden biri olmalı: :values.',
    'mimetypes' => ':attribute şu dosya türlerinden biri olmalı: :values.',
    'min' => [
        'numeric' => ':attribute en az :min olmalı.',
        'file' => ':attribute en az :min kilobayt olmalı.',
        'string' => ':attribute en az :min karakter olmalı.',
        'array' => ':attribute en az :min öğe olmalı.',
    ],
    'multiple_of' => ':attribute :value\'nin katı olmalı.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute formatı geçersiz.',
    'numeric' => ':attribute bir sayı olmalı.',
    'password' => 'Şifre yanlış.',
    'present' => ':attribute alanı mevcut olmalı.',
    'prohibited' => ':attribute alanı yasaklandı.',
    'prohibited_if' => ':other :value olduğunda :attribute alanı yasaklandı.',
    'prohibited_unless' => ':other :values içinde olmadığı sürece :attribute alanı yasaklandı.',
    'prohibits' => ':attribute alanı :other\'ın mevcut olmasını yasaklar.',
    'regex' => ':attribute formatı geçersiz.',
    'required' => ':attribute alanı gereklidir.',
    'required_array_keys' => ':attribute alanı şu girişleri içermelidir: :values.',
    'required_if' => ':other :value olduğunda :attribute alanı gereklidir.',
    'required_unless' => ':other :values içinde olmadığı sürece :attribute alanı gereklidir.',
    'required_with' => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_with_all' => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_without' => ':values mevcut olmadığında :attribute alanı gereklidir.',
    'required_without_all' => ':values\'den hiçbiri mevcut olmadığında :attribute alanı gereklidir.',
    'same' => ':attribute ve :other eşleşmelidir.',
    'size' => [
        'numeric' => ':attribute :size olmalı.',
        'file' => ':attribute :size kilobayt olmalı.',
        'string' => ':attribute :size karakter olmalı.',
        'array' => ':attribute :size öğe içermelidir.',
    ],
    'starts_with' => ':attribute şu değerlerden biri ile başlamalıdır: :values.',
    'string' => ':attribute bir metin olmalı.',
    'timezone' => ':attribute geçerli bir saat dilimi olmalı.',
    'unique' => ':attribute zaten alınmış.',
    'uploaded' => ':attribute yüklenemedi.',
    'url' => ':attribute geçerli bir URL olmalı.',
    'uuid' => ':attribute geçerli bir UUID olmalı.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'özel mesaj',
        ],
        'email' => [
            'required' => 'E-posta adresi gereklidir.',
            'email' => 'Geçerli bir e-posta adresi giriniz.',
            'unique' => 'Bu e-posta adresi zaten kullanılıyor.',
        ],
        'password' => [
            'required' => 'Şifre gereklidir.',
            'min' => 'Şifre en az :min karakter olmalıdır.',
            'confirmed' => 'Şifre onayı eşleşmiyor.',
        ],
        'password_confirmation' => [
            'required' => 'Şifre onayı gereklidir.',
        ],
        'name' => [
            'required' => 'Ad alanı gereklidir.',
            'string' => 'Ad geçerli bir metin olmalıdır.',
            'max' => 'Ad en fazla :max karakter olabilir.',
        ],
        'username' => [
            'required' => 'Kullanıcı adı gereklidir.',
            'unique' => 'Bu kullanıcı adı zaten alınmış.',
            'alpha_dash' => 'Kullanıcı adı sadece harf, sayı, tire ve alt çizgi içerebilir.',
        ],
        'phone' => [
            'required' => 'Telefon numarası gereklidir.',
            'regex' => 'Geçerli bir telefon numarası giriniz.',
        ],
        'captcha' => [
            'required' => 'Güvenlik doğrulaması gereklidir.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'ad',
        'username' => 'kullanıcı adı',
        'email' => 'e-posta adresi',
        'password' => 'şifre',
        'password_confirmation' => 'şifre onayı',
        'phone' => 'telefon',
        'mobile' => 'cep telefonu',
        'age' => 'yaş',
        'gender' => 'cinsiyet',
        'country' => 'ülke',
        'city' => 'şehir',
        'address' => 'adres',
        'message' => 'mesaj',
        'content' => 'içerik',
        'date' => 'tarih',
        'time' => 'zaman',
        'available' => 'mevcut',
        'size' => 'boyut',
        'file' => 'dosya',
        'image' => 'resim',
        'amount' => 'miktar',
        'title' => 'başlık',
        'description' => 'açıklama',
        'captcha' => 'güvenlik doğrulaması',
        'current_password' => 'mevcut şifre',
        'new_password' => 'yeni şifre',
        'confirm_password' => 'şifre onayı',
    ],

];