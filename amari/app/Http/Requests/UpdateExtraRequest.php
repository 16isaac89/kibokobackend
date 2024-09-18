<?php

namespace App\Http\Requests;

use App\Models\Extra;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExtraRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('extra_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'price' => [
                'string',
                'required',
            ],
        ];
    }
}
