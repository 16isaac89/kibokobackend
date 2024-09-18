<?php

namespace App\Http\Requests;

use App\Models\ZoneRide;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateZoneRideRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('zone_ride_edit');
    }

    public function rules()
    {
        return [
            'zone_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
