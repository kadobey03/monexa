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
        'symbol'
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

}
