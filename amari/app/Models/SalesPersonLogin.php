<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPersonLogin extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'user_login';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'login_time',
        'logout_time',
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function dealeruser(){
        return $this->belongsTo(DealerUser::class,'user_id');
    }

}
