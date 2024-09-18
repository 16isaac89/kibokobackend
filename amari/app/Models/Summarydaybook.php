<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Summarydaybook extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'summary_day_book';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'datecreated',
        'van_id',
        'expected',
        'received',
        'difference',
        'comment',
        'dispatch_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function van(){
        return $this->belongsTo(Van::class, 'van_id');
    }
}
