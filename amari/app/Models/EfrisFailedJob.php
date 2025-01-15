<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EfrisFailedJob extends Model
{
    use HasFactory;

    public $table = 'efris_failed_jobs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'sale_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function sale(){
        return $this->belongsTo(Sale::class, 'sale_id');
    }

}
