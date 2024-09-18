<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchProductsLocation extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'dispatchproductlocation';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        "dispatch_products_id",
        "location_id",
        "quantity",
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function sale(){
        return $this->belongsTo(Sale::class);
    }
}
