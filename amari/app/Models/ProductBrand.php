<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'brands';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'dealer_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function sales(){
        return $this->hasManyThrough(Sale::class,SaleProduct::class);
    }
    public function salesproducts(){
        return $this->hasMany(SaleProduct::class);
    }


}
