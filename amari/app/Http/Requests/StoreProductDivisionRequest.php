<?php

namespace App\Http\Requests;

use App\Models\ProductDivision;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProductDivisionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_division_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:product_divisions',
            ],
        ];
    }
}
