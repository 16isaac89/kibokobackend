<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariance extends Model
{
    use HasFactory;

    public $table = 'variances';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'product_id',
        'active',
        'multiple',
        'multipleof',
        'unitname',
        'pieceunitname',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
