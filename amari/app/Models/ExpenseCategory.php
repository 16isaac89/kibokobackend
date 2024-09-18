<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class ExpenseCategory extends Model
{
    use HasFactory;
    public $table = 'expensecategories';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($category) { // before delete() method call this
             $category->expenses()->delete();
             // do the rest of the cleanup...
        });
    }

   public function expenses(){
    return $this->hasMany(Expense::class);
   }

}
