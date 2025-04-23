<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDivision extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'product_divisions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function dealers()
    {
        return $this->belongsToMany(Dealer::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'product_division_id', 'id');
    }
    public function dealerUsers()
{
    return $this->belongsToMany(DealerUser::class);
}
}
