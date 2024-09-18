<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealerRole extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'dealer_roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'dealer_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function dealerpermissions()
    {
        return $this->belongsToMany(DealerPermission::class);
    }
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }


}
