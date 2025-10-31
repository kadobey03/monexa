<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoAccount extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'btc',
        'eth',
        'ltc',
        'xrp',
        'link',
        'bat',
        'aave',
        'usdt',
        'xlm',
        'bch',
    ];
    
    protected $attributes = [
        'btc' => 0.00,
        'eth' => 0.00,
        'ltc' => 0.00,
        'xrp' => 0.00,
        'link' => 0.00,
        'bat' => 0.00,
        'aave' => 0.00,
        'usdt' => 0.00,
        'xlm' => 0.00,
        'bch' => 0.00,
    ];
}
