<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    public $table = 'dealers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'tradename',
        'tin',
        'address',
        'phonenumber',
        'status',
        'efris',
        'deviceno',
        'privatekey',
        'keypwd',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
        "branch",
        "aeskey",
        "code",
        'type_of_business',
        'supervisor_id'
    ];
public function branches(){

        return $this->hasMany(Branch::class, 'dealer_id', 'id');

}
public function dealersubs(){

    return $this->hasMany(DealerSubscription::class,'dealer_id','id');

}
public function dealersubslat(){

    return $this->hasMany(DealerSubscription::class,'dealer_id','id')->latest();

}
public function dealerclients(){

    return $this->hasMany(Customer::class,'dealer_code','code');

}
public function users(){

    return $this->hasMany(DealerUser::class);

}
public function routes(){

    return $this->hasMany(Route::class,'dealer_code','code');

}
public function customers(){

    return $this->hasMany(Customer::class,'dealer_code','code');

}
public function updated_customers(){

    return $this->hasMany(Customer::class,'dealer_code','code');

}
public function new_customers(){

    return $this->hasMany(Customer::class,'dealer_code','code');

}
public function stockrequests(){

    return $this->hasMany(StockRequest::class,'dealer_id','id');

}
public function supervisor(){

    return $this->belongsTo(User::class,'supervisor_id','id');

}
public function productDivisions()
    {
        return $this->belongsToMany(ProductDivision::class);
    }
    //has many captain performance
    public function captains(){
        return $this->hasMany(CaptainPerformance::class,'dealer_id','id');
    }

}
