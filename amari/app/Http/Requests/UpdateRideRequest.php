<?php

namespace App\Http\Requests;

use App\Models\Ride;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRideRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ride_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'tonnage' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'capacity' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'manufacturer' => [
                'string',
                'required',
            ],
            'fare' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
