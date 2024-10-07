<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'gateway',
        'tnx_id',
        'ref_id',
        'amount',
        'status',
        'status_code',
        'notes',
        'extra',
        'response',
    ];

    protected $casts = [
        'extra' => 'array',
        'response' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
