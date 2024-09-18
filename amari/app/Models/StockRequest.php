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
        'total',
        'status',
        'requesttype',
        'customer_id',
        'delivered',
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
    public function saler(){
        return $this->belongsTo(DealerUser::class,'dealer_user_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','identification');
    }
}
