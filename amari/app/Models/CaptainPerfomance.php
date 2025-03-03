<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainPerfomance extends Model
{
    use HasFactory;

    public $table = 'captain_performance';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'added_customers',
        'visited_customers',
        'presale_orders',
        'dealer_id',
        'user_id',
        'message',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    //belongs to dealer
    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id');
    }

}
