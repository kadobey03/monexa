<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coinpayment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'cp_p_key',
        'cp_pv_key',
        'cp_m_id',
        'cp_debug_email',
        'cp_ipn_secret',
    ];
}
