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
        'start_date',
        'end_date',
        'sub_type',
        'tried',
        'type_of_business'
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
public function users(){

    return $this->hasMany(DealerUser::class);

}

}
