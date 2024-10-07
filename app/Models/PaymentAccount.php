<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_name',
        'account_no',
        'gateway',
        'customer_id',
        'order_id',
        'status',
        'payment_ref_id',
        'token',
        'token_type',
        'token_expire_at',
        'extra',
        'subdomain',
    ];

    protected $casts = [
        'extra' => 'array',
    ];
}
