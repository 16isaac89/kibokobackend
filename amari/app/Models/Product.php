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
        'stock',
        'price',
        'stockwarning',
        "measureUnit",
        'unit',
        "currency",
        "sync",
        'location_id',
        "openingstock",
        'created_at',
        'updated_at',
        'deleted_at',
        'cost',
        'suppvat',
        'totalcost',
        'supplier_id',
        'product_category_id',
        'category',
        'dealer_id',
        'branch_id',
        'tax_id',
        'product_code',
        'efriscategorycode'
    ];

   public function brand(){
    return $this->belongsTo(ProductBrand::class, 'brand_id');
   }
   public function efrisproduct(){
    return $this->hasOne(EfrisProduct::class,'product_id');
}

public function locationproducts(){
    return $this->hasMany(LocationProduct::class,'product_id');
}
public function stocks(){
    return $this->hasMany(Stock::class,'product_id');
}
public function dispatchproducts(){
    return $this->hasMany(DispatchProducts::class,'product_id');
}
public function variances(){
    return $this->hasMany(ProductVariance::class);
}
public function van(){
    $this->belongsToThrough(Van::class,DispatchProducts::class);
}
public function supplier(){
    return $this->belongsTo(Supplier::class, 'supplier_id');
}
public function productcategory(){
    return $this->belongsTo(ProductCategory::class, 'product_category_id');
}
public function stockcount(){
    return $this->hasMany(StockCount::class);
}

public function returns(){
    return $this->hasMany(SalesReturnItem::class);
}

public function sales(){
    return $this->hasMany(SaleProduct::class);
}

public function dispatchcounts(){
    return $this->hasMany(DispatchCount::class);
}

public function damagesexp(){
    return $this->hasMany(StockDamage::class);
}
public function efrissync(){
    return $this->hasOne(EfrisSync::class);
}
// public function tax(){
//     return $this->hasOne(Tax::class, 'tax_id','id');
// }
public function getProductTaxAttribute(){
    return Tax::find($this->tax_id)?->value;
}

}
