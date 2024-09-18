<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchProducts extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'dispatch_products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'dispatch_id',
        'product_id',
        'name',
        'dispatchedquantity',
        'quantity',
        'price',
        'brand_id',
        'sellingprice',
        'created_at',
        'updated_at',
        'deleted_at',
        'sold',
        'count',
        'stock',
        'brandname',
        'van_id',
        'batch',
        'discount',
        'sale_type',
    ];
    public function pbrand(){
        return $this->belongsTo(ProductBrand::class,'brand');
    }
    public function batchstock(){
        return $this->belongsTo(Stock::class,'batch');
    }
    public function van(){
        return $this->belongsTo(Van::class,'van_id');
    }
    public function dispatchcount(){
        return $this->hasOne(DispatchCount::class,'dispatch_product_id');
    }
}
