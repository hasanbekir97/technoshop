<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lang extends Model
{
    use HasFactory;

    protected $table = 'langs';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'lang_id',
        'name'
    ];
}
