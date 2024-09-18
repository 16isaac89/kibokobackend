<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchCount extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'dispatch_counts';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'dispatch_product_id',
        'dispatched',
        'van_id',
        'dispatch_id',
        'dealer_id',
        'branch_id',
        'sold',
        'count',
        'count_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function product(){
        return $this->belongsTo(DispatchCount::class,'product_id');
    }
    public function dispatch(){
        return $this->belongsTo(Dispatch::class,'dispatch_id');
    }
    public function dispatchproductid(){
        return $this->belongsTo(DispatchProducts::class,'dispatch_product_id');
    }
}
