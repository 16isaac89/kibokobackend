<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    public $table = 'routes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'dealer_id',
        'branch_id',
        'dealer_code',
        'code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function dealer(){
        return $this->belongsTo(Dealer::class, 'dealer_code','code');
    }
    public function routeplans(){
        return $this->hasMany(RoutePlan::class, 'route_id');
    }

    public function sales(){
        return $this->hasMany(Sale::class, 'route','code');
    }
    public function customers(){
        return $this->hasMany(Customer::class, 'route_code','code');
    }
    public function routesalers(){
        return $this->hasOneThrough(DealerUser::class, Sale::class);
    }
    public function saler(){
        return $this->hasOneThrough(DealerUser::class,RoutePlan::class);
    }

}
