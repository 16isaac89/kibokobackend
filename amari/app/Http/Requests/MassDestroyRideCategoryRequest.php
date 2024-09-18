<?php

namespace App\Http\Requests;

use App\Models\RideCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRideCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ride_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ride_categories,id',
        ];
    }
}
