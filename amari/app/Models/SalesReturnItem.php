<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesReturnItem extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'sales_returns';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'sales_product_id',
        'qty_returned',
        'van_id',
        'return_date',
        'total_returned',
        'return_tax',
        'batch',
        'receipt',
        'status',
        'return_id',
        'approved_qty',
        'customer_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function salesitem()
    {
        return $this->belongsTo(SaleProduct::class,'sales_item');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function return(){
        return $this->belongsTo(SaleReturn::class,'return_id');  
    }

    
}
