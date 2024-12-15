<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public $table = 'sales';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'dealer_user_id',
        'route_id',
        'van_id',
        'dealer_id',
        'total',
        'customer_id',
        'type',
        'efristatus',
        'latitude',
        'longitude',
        "taxamount",
        "checkin",
        "checkout",
        'created_at',
        'updated_at',
        'deleted_at',
        'totalbefore',
        'vat',
        'saleidentification',
        'datecreated',
        'dealer_id',
        'branch_id'
    ];
    public function dealer(){
        return $this->belongsTo(Dealer::class,'dealer_id');
    }
    public function route(){
        return $this->belongsTo(Route::class,'route_id');
    }
    public function van(){
        return $this->belongsTo(Van::class,'van_id');
    }
    public function user(){
        return $this->belongsTo(DealerUser::class,'dealer_user_id');
    }
    public function items(){
        return $this->hasMany(SaleProduct::class,'sale_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','identification');
    }


    public function efrisdoc(){
        return $this->hasOne(EfrisDocument::class);
    }

}
