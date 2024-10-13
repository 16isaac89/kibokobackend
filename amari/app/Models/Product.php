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
        'product_category_id',
        'tax_id',
        'efriscategorycode'
    ];

   public function brand(){
    return $this->belongsTo(ProductBrand::class, 'brand_id','code');
   }

   public function efrisproduct(){
    return $this->hasOne(EfrisProduct::class,'product_id');
}




public function category(){
    return $this->belongsTo(ProductCategory::class, 'product_category_id','code');
}

public function getProductTaxAttribute(){
    return Tax::find($this->tax_id)?->value;
}

}
