<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerSubscription extends Model
{
    use HasFactory;
    public $table = 'dealer_subscriptions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'subscription_id',
        'dealer_id',
        'from_date',
        'to_date',
        'paid_on',
        'transaction_id',
        'status',
        'ptmethod',
        'discount',
        'quantity',
        'ammount'
    ];
    public function dealer(){
        return $this->belongsTo(Dealer::class,'dealer_id');
    }
    public function subscription(){
        return $this->belongsTo(Subscription::class,'subscription_id');
    }
}
