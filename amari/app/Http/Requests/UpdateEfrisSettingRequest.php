<?php

namespace App\Http\Requests;

use App\Models\EfrisSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEfrisSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('efris_setting_edit');
    }

    public function rules()
    {
        return [
            'aeskey' => [
                'string',
                'nullable',
            ],
            'tin' => [
                'string',
                'nullable',
            ],
            'deviceno' => [
                'string',
                'nullable',
            ],
        ];
    }
}
