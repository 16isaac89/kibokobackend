<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'purchaseorders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'total',
        'status',
        'supplier_id',
        'reference',
        'date',
        'receivedate',
        'dealer_id',
        'ordered_by',
        'received_by',
        'item_count',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function user(){
        return $this->belongsTo(User::class,'ordered_by');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function products(){
        return $this->hasMany(PurchaseOrderProducts::class);
    }

}
