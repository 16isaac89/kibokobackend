<?php

namespace App\Http\Requests;

use App\Models\RideCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRideCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ride_category_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'passengers' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
