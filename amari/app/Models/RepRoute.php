<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepRoute extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'reproute';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'dealer_user_id',
        'route_id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function route(){
        return $this->belongsTo(Route::class,'route_id');
    }
}
