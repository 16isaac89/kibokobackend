<?php

namespace App\Http\Requests;

use App\Models\ZoneRide;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyZoneRideRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('zone_ride_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:zone_rides,id',
        ];
    }
}
