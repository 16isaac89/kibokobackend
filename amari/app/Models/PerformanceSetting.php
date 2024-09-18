<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceSetting extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'performance_settings';

    protected $dates = [
        'fromdate',
        'todate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'fromdate',
        'todate',
        'points',
        'pointtype',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getFromdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setFromdateAttribute($value)
    {
        $this->attributes['fromdate'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getTodateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setTodateAttribute($value)
    {
        $this->attributes['todate'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
