<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkuTargetProduct extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'sku_target_product';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'sku_target_id',
        'product_id',
        'target_quantity',
        'selling_price',
        'batch',
        'product_name',
        'total',
        'user_id',
        'fromdate',
        'todate',
        'sold',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function target(){
        return $this->belongsTo(SkuTarget::class,'sku_target_id');
    }
}
