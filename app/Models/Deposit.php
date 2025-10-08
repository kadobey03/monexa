<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
        'payment_mode',
        'proof',
        'txn_id',
        'user',
        'plan',
        'signals',
        'created_at',
        'updated_at'
    ];

    public function duser(){
    	return $this->belongsTo('App\Models\User', 'user');
    }

    public function dplan(){
    	return $this->belongsTo('App\Models\Plans', 'plan');
    }
}
