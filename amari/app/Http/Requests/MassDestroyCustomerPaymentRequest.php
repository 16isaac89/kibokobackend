<?php

namespace App\Http\Requests;

use App\Models\CustomerPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCustomerPaymentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('customer_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:customer_payments,id',
        ];
    }
}
