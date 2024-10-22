<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Van extends Model
{
    use HasFactory;
    public $table = 'vans';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'reg_id',
        'dealer_id',
        'branch_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function dealerusers()
    {
        return $this->hasMany(DealerUser::class);
    }
    public function dealer()
    {
        return $this->belongsTo(Dealer::class,'dealer_id');
    }
    public function sales()
    {
        return $this->hasMany(Sale::class,'van_id');
    }
    public function stockrequests()
    {
        return $this->hasMany(StockRequest::class,'van_id','id');
    }
    public function target(){
        return $this->hasOne(Target::class,'dealer_user_id','id');
    }
    public function routeplan(){
        return $this->hasManyThrough(RoutePlanList::class,DealerUser::class);
    }
    public function summarydaybook(){
        return $this->hasMany(Summarydaybook::class,'van_id');
    }


}
