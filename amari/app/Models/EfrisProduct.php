<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EfrisProduct extends Model
{
    use HasFactory;
    public $table = 'efrisproducts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'category',
        'goodscode',
        
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function dealerproduct(){
        return $this->belongsTo(DealerProduct::class,'product_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
