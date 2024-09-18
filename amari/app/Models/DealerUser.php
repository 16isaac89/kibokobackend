<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class DealerUser extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;


    public $table = 'dealerusers';
    protected $fillable = [
        'dealer_id',
        'type',
        'username',
        'phone',
        'password',
        'van_id',
        'status',
        'token',
        'targettype',
        'created_at',
        'authtoken',
        'updated_at',
        'deleted_at',
        'branch_id',
    ];
    public function van()
    {
        return $this->belongsTo(Van::class,'van_id');
    }
    public function dealer()
    {
        return $this->belongsTo(Dealer::class,'dealer_id','id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function target()
    {
        return $this->hasOne(Target::class,'dealer_user_id','id')->latest();
    }
    public function skutarget()
    {
        return $this->hasOne(SkuTarget::class,'user_id','id');
    }
    public function sales(){
        return $this->hasMany(Sale::class,'dealer_user_id','id');
    }
    public function routeplan(){
        return $this->hasOne(RoutePlan::class,'dealer_user_id','id');
    }
    public function plans(){
        return $this->hasMany(RoutePlanList::class,'dealer_user_id','id');
    }
    public function route(){
        return $this->belongsTo(Route::class);
    }
    public function logins(){
        return $this->hasMany(SalesPersonLogin::class,'user_id','id');
    }
    public function dealerroles()
    {
        return $this->belongsToMany(DealerRole::class);
    }
}
