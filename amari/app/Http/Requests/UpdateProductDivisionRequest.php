<?php

namespace App\Http\Requests;

use App\Models\ProductDivision;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProductDivisionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_division_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:product_divisions,name,' . request()->route('product_division')->id,
            ],
        ];
    }
}
