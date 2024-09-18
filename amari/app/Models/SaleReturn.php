<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturn extends Model
{
    
    use SoftDeletes;
    use HasFactory;

    public $table = 'sales_return';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'status',
        'van_id',
        'user',
        'requested_by',
        'customer_id',
        'sale_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function salesitem()
    {
        return $this->belongsTo(SaleProduct::class,'sales_item');
    }
    public function items(){
        return $this->hasMany(SalesReturnItem::class,'return_id');  
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','identification');
    }
    
}
