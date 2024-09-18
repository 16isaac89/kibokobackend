<?php

namespace App\Http\Requests;

use App\Models\Performance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPerformanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('performance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:performances,id',
        ];
    }
}
