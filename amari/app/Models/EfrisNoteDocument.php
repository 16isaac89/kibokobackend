<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EfrisNoteDocument extends Model
{
    use HasFactory;
    public $table = 'efris_note_document';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'sale_id',
        'type',
        'reference',
        'status',
        'fdn',
        'ver_code',
        'efris_document_id',
        'beforetotal',
        'aftertotal',
        'cr_inv_no',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function sale(){
        return $this->belongsTo(Sale::class);
    }
    public function document(){
        return $this->belongsTo(EfrisDocument::class,'efris_document_id','id');
    }

}
