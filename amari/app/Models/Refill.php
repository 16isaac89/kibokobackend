<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refill extends Model
{
    use HasFactory;

    public $table = 'refills';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'beforeqty',
        'refill',
        'dispatch_product_id',
        'dispatch_id',
        // 'van_product',
        'van_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
