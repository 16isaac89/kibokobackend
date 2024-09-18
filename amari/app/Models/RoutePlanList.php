<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoutePlanList extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'routeplan_list';
    protected $primaryKey ="id";
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'customer_id',
        'name',
        'routename',
        'route_id',
        'dealer_user_id',
        'dealer_id',
        'week',
        'day',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function routeplan(){
        return $this->belongsTo(RoutePlan::class, 'routeplan_id');
    }
    public function route(){
        return $this->belongsTo(Route::class,'route_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','identification');
    }
    public function saler(){
        return $this->belongsTo(DealerUser::class,'dealer_user_id'); 
    }
   
}
