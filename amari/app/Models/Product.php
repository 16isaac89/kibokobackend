<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'products';
protected $appends = [
'product_tax'
];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'brand_id',
        'code',
        'unit',
        "sync",
        'created_at',
        'updated_at',
        'deleted_at',
        'product_category',
        'selling_price',
        'tax_amount',
        'tax_id',
        'efriscategorycode',
        'group',
        'division',
    ];

   public function brand(){
    return $this->belongsTo(ProductBrand::class, 'brand_id','code');
   }
   public function tax(){
    return $this->belongsTo(Tax::class, 'tax_id','id');
   }

   public function efrisproduct(){
    return $this->hasOne(EfrisProduct::class,'product_id');
}

public function category(){
    return $this->belongsTo(ProductCategory::class, 'product_category','code');
}
public function dealerproduct(){
    return $this->hasOne(DealerProduct::class, 'product_id','id');
}

public function getProductTaxAttribute(){
    return Tax::find($this->tax_id)?->value;
}

}
