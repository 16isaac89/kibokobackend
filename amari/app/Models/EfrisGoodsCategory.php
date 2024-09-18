<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EfrisGoodsCategory extends Model
{
    use HasFactory;
    public $table = 'efris_category';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        "segment_name",
        "family_name",
        "class_name",
        "commodity_code",
        "commodity_name",
        "service",
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
