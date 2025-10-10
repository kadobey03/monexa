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
        return optional($this->user)->name ?? 'Kullanıcı Bulunamadı';
    }

    public function getUserEmailAttribute(){
        return optional($this->user)->email ?? 'Belirtilmemiş';
    }

}
