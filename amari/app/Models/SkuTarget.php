<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkuTarget extends Model
{
   
    use SoftDeletes;
    use HasFactory;

    public $table = 'sku_target';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'fromdate',
        'todate',
        'month',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function items(){
        return $this->hasMany(SkuTargetProduct::class,'sku_target_id');
    }
    public function saler(){
        return $this->belongsTo(DealerUser::class, 'user_id');
    }
    
}
