<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsCont extends Model
{
    use HasFactory;

    protected $fillable = [
        'use_crypto_feature',
    ];

    protected $casts = [
        'use_crypto_feature' => 'boolean',
    ];
}
