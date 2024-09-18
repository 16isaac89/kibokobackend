<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'product-units';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'shortname',
        'allow_decimal',
        'has_base',
        'dealer_id',
        'base_unit',
        'multiplier',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
