<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_plans extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan',
        'amount',
        'activate',
        'inv_duration',
        'expire_date',
        'activated_at',
        'last_growth',
        'assets',
        'type',
        'leverage',
        'profit_earned',
        'active',
        'symbol',
        'user',
        'user_name',
        'user_email'
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'last_growth' => 'datetime',
        'expire_date' => 'datetime',
    ];

    public function dplan(){
        return $this->belongsTo(Plans::class, 'plan', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function getUserNameAttribute(){
        // İlişki yüklenmiş ve geçerli mi kontrol et
        if ($this->relationLoaded('user') && $this->user && is_object($this->user)) {
            return $this->user->name;
        }

        // İlişki yüklenmemişse, user_name alanı varsa onu kullan
        if (!empty($this->user_name)) {
            return $this->user_name;
        }

        return 'Kullanıcı Bulunamadı';
    }

    public function getUserEmailAttribute(){
        // İlişki yüklenmiş ve geçerli mi kontrol et
        if ($this->relationLoaded('user') && $this->user && is_object($this->user)) {
            return $this->user->email;
        }

        // İlişki yüklenmemişse, user_email alanı varsa onu kullan
        if (!empty($this->user_email)) {
            return $this->user_email;
        }

        return 'Belirtilmemiş';
    }

    public function getUserStatusAttribute(){
        // İlişki yüklenmiş ve geçerli mi kontrol et
        if ($this->relationLoaded('user') && $this->user && is_object($this->user)) {
            return $this->user->status ?? 'Bilinmiyor';
        }

        return 'Bilinmiyor';
    }

    /**
     * Geçersiz user ID'leri otomatik düzelt ve user_name/user_email'i güncelle
     */
    public static function fixInvalidUserIds()
    {
        $allUserIdsInTrades = self::whereNotNull('user')->where('user', '!=', 0)->pluck('user')->unique();
        $existingUserIds = User::pluck('id')->toArray();
        $missingUserIds = $allUserIdsInTrades->diff($existingUserIds)->values();

        if ($missingUserIds->isNotEmpty()) {
            foreach ($missingUserIds as $invalidId) {
                $tradeCount = self::where('user', $invalidId)->count();

                if ($tradeCount > 0) {
                    // Geçersiz user ID'yi null yap
                    self::where('user', $invalidId)->update(['user' => null]);
                    \Log::info("Geçersiz user ID {$invalidId} düzeltildi. {$tradeCount} kayıt etkilendi.");
                }
            }

            return $missingUserIds->sum(function($id) {
                return self::where('user', $id)->count();
            });
        }

        return 0;
    }

    /**
     * User ilişkisi yüklenemediğinde user_name ve user_email alanlarını güncelle
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Eğer user ilişkisi yüklenmiş ve null ise, user_name ve user_email alanlarını temizle
            if ($model->relationLoaded('user') && is_null($model->user)) {
                $model->user = null;
                $model->user_name = null;
                $model->user_email = null;
            }
        });

        static::retrieved(function ($model) {
            // Eğer user ilişkisi yüklenmiş ve geçersiz ise, otomatik düzelt
            if ($model->relationLoaded('user') && $model->user === null && !is_null($model->getOriginal('user'))) {
                // Geçersiz user ID'yi tespit ettik, düzeltelim
                $model->user = null;
                $model->user_name = null;
                $model->user_email = null;
                $model->save();
            }
        });
    }

}
