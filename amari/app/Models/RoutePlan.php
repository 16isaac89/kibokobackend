<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutePlan extends Model
{
    use HasFactory;

    public $table = 'routeplan';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'route_id',
        'dealer_user_id',
        'dealer_id',
        'week',
        'day',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function saler(){
        return $this->belongsTo(DealerUser::class, 'dealer_user_id');
    }
    public function dealer(){
        return $this->belongsTo(Dealer::class, 'dealer_id');
    }
    public function route(){
        return $this->belongsTo(Route::class, 'route_id');
    }
    public function list(){
        return $this->hasMany(RoutePlanList::class, 'routeplan_id');
    }
}
