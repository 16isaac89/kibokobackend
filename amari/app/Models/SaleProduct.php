<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleProduct extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'sales_products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
protected $appends = [
'sale_product_tax'
];
    protected $fillable = [
        'sale_id',
        'product_id',
        'name',
        'quantity',
        'addition',
        'total',
        'discount',
        'customer',
        'van',
        'product_variance_id',
        'route_id',
        'discount',
        'deduction',
        'hosanavat',
        'totalcost',
        'qtybefore',
        'product_brand_id',
        'totalafter',
        'created_at',
        'updated_at',
        'deleted_at',
        'sellingprice',
        'withoutdiscount',
        'batch',
        'tax_id',
        'sale_type',
        'credit_note_value',
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function sale(){
        return $this->belongsTo(Sale::class,'sale_id');
    }
    public function brand(){
        return $this->belongsTo(ProductBrand::class);
    }
    public function van()
    {
        return $this->hasOneThrough(Van::class, Sale::class);
    }

    public function client(){
        return $this->belongsTo(Customer::class,'customer','identification');
    }

    public function getSaleProductTaxAttribute(){
        return Tax::find($this->tax_id)->value;
    }

}
