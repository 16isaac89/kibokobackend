<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerProduct extends Model
{
    use HasFactory;
    public $table = 'dealer_products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'dealer_id',
        'efris_product_code',
        'stock',
        'sellingprice',
        'discount',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function brand(){
        return $this->belongsTo(ProductBrand::class,'brand_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function sync(){
        return $this->belongsTo(EfrisSync::class,'product_id');
    }
    public function stocks(){
        return $this->hasMany(Stock::class,'product_id','id');
    }


}
