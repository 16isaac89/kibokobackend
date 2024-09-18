<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    public $table = 'targets';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'month',
        'year',
        'money',
        'dealer_id',
        'dealer_user_id',
        'type',
        'fromdate',
        'todate',
        'targettype',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function saler(){
        return $this->belongsTo(DealerUser::class, 'saler_id');
    }
}
