<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountHistory extends Model
{
    use HasFactory;
    public $table = 'discount_history';

        protected $dates = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        protected $fillable = [
            'product_id',
            'dealer_product_id',
            'discount',
            'item_price',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        public function product(){
            return $this->belongsTo(Product::class,'product_id','id');
        }

        public function dealer_product(){
            return $this->belongsTo(DealerProduct::class,'dealer_product_id','id');
        }
}
