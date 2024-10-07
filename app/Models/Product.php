<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
        'extra',
    ];

    protected $casts = [
        'extra' => 'array',
    ];

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
