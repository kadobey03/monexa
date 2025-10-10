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
        // Önce ilişkiyi kontrol et, sonra user_name alanını kullan
        if ($this->user) {
            return $this->user->name;
        }

        // Eğer ilişki null ise ve user_name alanı varsa onu kullan
        if (!empty($this->user_name)) {
            return $this->user_name;
        }

        return 'Kullanıcı Bulunamadı';
    }

    public function getUserEmailAttribute(){
        // Önce ilişkiyi kontrol et, sonra user_email alanını kullan
        if ($this->user) {
            return $this->user->email;
        }

        // Eğer ilişki null ise ve user_email alanı varsa onu kullan
        if (!empty($this->user_email)) {
            return $this->user_email;
        }

        return 'Belirtilmemiş';
    }

    public function getUserStatusAttribute(){
        return optional($this->user)->status ?? 'Bilinmiyor';
    }

}
