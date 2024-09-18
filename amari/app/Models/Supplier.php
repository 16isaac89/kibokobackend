<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory,SoftDeletes;


    public $table = 'suppliers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'tin',
        'name',
        'address',
        'phone',
        'email',
        'dealer_id',

        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function products(){
        return $this->hasMany(Product::class, 'supplier_id');
    }
}
