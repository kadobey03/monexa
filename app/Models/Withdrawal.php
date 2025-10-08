<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
        'payment_mode',
        'paydetails',
        'to_deduct',
        'user',
        'txn_id',
        'created_at',
        'updated_at'
    ];

    public function duser(){
    	return $this->belongsTo(User::class , 'user');
    }
}
