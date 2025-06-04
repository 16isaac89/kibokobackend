<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clockin extends Model
{
    use HasFactory;
    public $table = 'clockins';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'from_time',
        'to_time',
        'dealer_user_id',
        'lat',
        'longitude',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function dealerUser()
    {
        return $this->belongsTo(DealerUser::class, 'dealer_user_id');
    }

}
