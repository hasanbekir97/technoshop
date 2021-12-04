<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'order_status_id',
        'name'
    ];
}
