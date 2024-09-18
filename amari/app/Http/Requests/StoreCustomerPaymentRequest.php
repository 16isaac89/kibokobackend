<?php

namespace App\Http\Requests;

use App\Models\CustomerPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCustomerPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_payment_create');
    }

    public function rules()
    {
        return [
            'received_by_id' => [
                'required',
                'integer',
            ],
            'date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'customer_id' => [
                'required',
                'integer',
            ],
            'amount' => [
                'required',
            ],
        ];
    }
}
