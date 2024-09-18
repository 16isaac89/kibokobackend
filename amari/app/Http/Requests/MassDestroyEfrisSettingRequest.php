<?php

namespace App\Http\Requests;

use App\Models\EfrisSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEfrisSettingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('efris_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:efris_settings,id',
        ];
    }
}
