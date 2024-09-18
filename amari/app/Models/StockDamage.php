<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockDamage extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'stock_damages';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'count',
        'date',
        'comment',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
