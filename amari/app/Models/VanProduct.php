<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VanProduct extends Model
{
    use HasFactory;
    public $table = 'van_products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'brand_id',
        'name',
        'dealer_id',
        'stock',
        'van_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'quantity',
        'price'
    ];
    public function dealerproduct(){
        return $this->belongsTo(DealerProduct::class,'product_id','product_id');
    }
   
}
