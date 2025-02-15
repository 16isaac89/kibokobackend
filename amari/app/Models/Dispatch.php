<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    use HasFactory;
    public $table = 'dispatches';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'total',
        'user_id',
        'count',
        'type',
        'dealer_user_id',
        'dealer_id',
        'branch_id',
        'van_id',
        'counted',
        'countdate',
        'dispatchdate',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function dealer(){
        return $this->belongsTo(Dealer::class, 'dealer_id');
    }
    public function van(){
        return $this->belongsTo(Van::class, 'van_id');
    }
    public function dealeruser(){
        return $this->belongsTo(DealerUser::class, 'dealer_user_id');
    }
    public function dispatchproducts(){
        return $this->hasMany(DispatchProducts::class);
    }
    public function dispatchcounts(){
        return $this->hasMany(DispatchCount::class,'dispatch_id');
    }
    public function dispatchbrand(){
        return $this->hasOneThrough(ProductBrand::class,DispatchProducts::class);
    }
}
