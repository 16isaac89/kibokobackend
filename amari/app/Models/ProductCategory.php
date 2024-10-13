<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'product_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        // 'dealer_id',
        'code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function products(){
        return $this->hasMany(Product::class, 'product_category','code');
    }
}
