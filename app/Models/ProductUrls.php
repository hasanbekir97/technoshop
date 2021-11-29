<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUrls extends Model
{
    use HasFactory;

    protected $table = 'product_urls';

    protected $fillable = [
        'lang_id',
        'product_id',
        'slug',
        'name',
        'description',
        'detail'
    ];
}
