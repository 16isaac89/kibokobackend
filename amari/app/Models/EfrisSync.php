<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EfrisSync extends Model
{
    use HasFactory;

    public $table = 'efris_syncs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'product_id',
        'time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function dealerproduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
