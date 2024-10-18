<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequestProduct extends Model
{
    use HasFactory;

    public $table = 'stockreqproduct';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'stock_request_id',
        'product_id',
        'reqqty',
        'appqty',
        'van_id',
        'batch_id',
        'sellingprice',
        'dealer_product_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'discount',
        'sale_type',
        'vat',
        'vat_amount',
        'total',
    ];

    public function stockreqs(){
        return $this->belongsTo(StockRequest::class,'stock_request_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function van(){
        return $this->belongsTo(Van::class,'van_id');
    }
}
