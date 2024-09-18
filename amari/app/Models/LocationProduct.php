<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
 

    public $table = 'product_location';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'countdate'
    ];

    protected $fillable = [
        'location_id',
        'product_id',
        'quantity',
        'countdate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function location(){
        return $this->belongsTo(Location::class,'location_id');
    }
}
