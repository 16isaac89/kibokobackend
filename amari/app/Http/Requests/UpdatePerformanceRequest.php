<?php

namespace App\Http\Requests;

use App\Models\Performance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePerformanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('performance_edit');
    }

    public function rules()
    {
        return [];
    }
}
