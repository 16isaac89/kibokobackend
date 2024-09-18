<?php

namespace App\Http\Requests;

use App\Models\PerformanceSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePerformanceSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('performance_setting_create');
    }

    public function rules()
    {
        return [
            'fromdate' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'todate' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
