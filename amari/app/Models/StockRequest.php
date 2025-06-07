<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    use HasFactory;

    public $table = 'stockrequests';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'van_id',
        'dealer_user_id',
        'dealer_id',
        'total',
        'route',
        'status',
        'requesttype',
        'invoice_no',
        'customer_id',
        'checkin',
        'checkout',
        'delivered',
        'customer_identification',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function items(){
        return $this->hasMany(StockRequestProduct::class);
    }
    public function van(){
        return $this->belongsTo(Van::class);
    }
    public function customerroute(){
        return $this->belongsTo(Route::class,'route','code');
    }
    public function saler(){
        return $this->belongsTo(DealerUser::class,'dealer_user_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function requestcustomer(){
        return $this->belongsTo(Customer::class,'customer_identification','identification');
    }
    public function dealer(){
        return $this->belongsTo(Dealer::class,'dealer_id','id');
    }
}
