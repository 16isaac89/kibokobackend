<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'stock';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'period',
        'product_id',
        'amount',
        'comment',
        'sellingprice',
        'sold',
        'batch',
        'cost',
        'receivedate',
        'expirydate',
        'supplier_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function salesproducts(){
        return $this->hasMany(SaleProduct::class,'batch');
    }
    public function dispatchproduct(){
        return $this->belongsTo(DispatchProducts::class);
    }
    public static function boot() {
        parent::boot();

        static::deleting(function($stock) { // before delete() method call this
             $stock->salesproducts()->delete();
             // do the rest of the cleanup...
        });
    }
}
