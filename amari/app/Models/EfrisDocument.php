<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EfrisDocument extends Model
{
    use HasFactory;
    public $table = 'efris_document';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        "fdn",
        "invoiceid",
        "invoiceindustrycode",
        "invoicekind",
        "invoiceno",
        "invoicetype",
        "issuedate",
        "buyerref",
        'dealer_id',
        'qrcode',
        'sale_id',
        'inv_id',
        'inv_no',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function sale(){
        return $this->belongsTo(Sale::class);
    }
    public function note(){
        return $this->hasMany(EfrisNoteDocument::class);
    }

}
