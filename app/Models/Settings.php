<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'site_title',
        'site_name',
        'currency',
        'referral_commission',
        'contact_email',
        'trade_mode',
        'enable_2fa',
        'enable_kyc',
        'enable_verification',
        'withdrawal_option',
        'return_capital',
        'should_cancel_plan',
        'modules',
        // Yeni eklenen alanlar
        'timezone',
        'install_type',
        'merchant_key',
        'welcome_message',
        'whatsapp',
        'telegram',
        'twak',
        'tido',
        'trading_winrate',
        'usertheme',
        // Controller'da kullanılan diğer alanlar
        'newupdate',
        'description',
        'keywords',
        'logo',
        'favicon',
        'tawk_to',
        'site_address'
    ];

    protected $casts = [
        'return_capital' => 'boolean',
        'should_cancel_plan' => 'boolean',
        'modules' => 'array'
    ];

    // public function getModulesAttribute($value)
    // {
    //     return ucfirst($value);
    // }
}