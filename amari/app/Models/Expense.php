<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class Expense extends Model
{
    use HasFactory;
    public $table = 'expenses';

    protected $fillable = [
        'name',
        'expense_category_id',
        'user_id',
        'amount',
        'description',
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

   public function category(){
    return $this->belongsTo(ExpenseCategory::class,'expense_category_id');
   }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
