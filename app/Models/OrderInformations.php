<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderInformations extends Model
{
    use HasFactory;

    protected $table = 'order_informations';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'order_id',
        'phone',
        'country',
        'city',
        'county',
        'address'
    ];
}
