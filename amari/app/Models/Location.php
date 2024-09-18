<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    
    use SoftDeletes;
    use HasFactory;

    public $table = 'locations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function products(){
        return $this->hasMany(Product::class,'location_id');
    }
    public function locps(){
        return $this->hasMany(LocationProduct::class,'location_id');
    }
    

}
