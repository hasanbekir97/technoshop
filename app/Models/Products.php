<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'sku',
        'brand',
        'cat_id',
        'old_price',
        'discount_rate',
        'price',
        'cargo_price',
        'stock',
        'star_avg',
        'star_number'
    ];
}
