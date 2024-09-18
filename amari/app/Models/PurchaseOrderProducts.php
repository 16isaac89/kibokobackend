<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderProducts extends Model
{
    
    use HasFactory;
    use SoftDeletes;

    public $table = 'purchaseorders_products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'brand_id',
        'product_id',
        'cost',
        'actual',
        'purchase_order_id',
        'req_quantity',
        'received_quantity',
        'expiry_date',
        'total_cost',
        'actual_total',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function purchaseorder(){
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
