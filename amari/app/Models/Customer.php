<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'customers';

protected $appends = [
        'location_image'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'phone',
        'tin',
        'address',
        'category_id',
        'route_id',
        'dealer_id',
        'branch_id',
        'status',
        'credit',
        'identification',
        'efrisstatus',
        'buyerType',

		'email',
        'contact_person',
        'telno',
        'area',
        'city',
        'country',
        'classification',
        'cashregisters',
        'dailyfootfall',
        'productrange',
		'custcategory',
        'dealer_code',
        'route_code',
		'latitude',
		'longitude',
		'customertype',
		'customercheckin',
		'customercheckout',
		'userid',
		'subdimagelat',
		'subdimagelong',
        'businessvalue',
        'location',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

	public function getLocationImageAttribute()
    {
        $file = $this->getMedia('location_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
        }

        return $file;
    }

    public function route(){
        return $this->belongsTo(Route::class, 'route_code','code');
    }

    public function category(){
        return $this->belongsTo(CustomerCategory::class, 'category_id');
    }
    public function dealer(){
        return $this->belongsTo(Dealer::class, 'dealer_code','code');
    }
    public function distributor(){
        return $this->belongsTo(Dealer::class, 'dealer_code');
    }
    public function requests(){
        return $this->hasMany(StockRequest::class,'customer_id','identification');
    }
}
