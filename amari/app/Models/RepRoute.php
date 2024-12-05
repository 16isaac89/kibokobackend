<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepRoute extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'reproute';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'dealer_user_id',
        'route_id',
        'name',
        'van_id',
        'day',
        'week',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function route(){
        return $this->belongsTo(Route::class,'route_id','id');
    }
    public function list(){
        return $this->hasMany(RoutePlanList::class,'rep_route_id','id');
    }
    public function dealeruser(){
        return $this->belongsTo(DealerUser::class,'dealer_user_id','id');
    }
    public function van(){
        return $this->belongsTo(Van::class,'van_id','id');
    }
    public function forceDelete()
    {
        // delete all related photos
        $this->list()->forceDelete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::forceDelete();
    }
}
