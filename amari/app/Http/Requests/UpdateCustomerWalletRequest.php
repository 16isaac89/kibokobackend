<?php

namespace App\Http\Requests;

use App\Models\CustomerWallet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCustomerWalletRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_wallet_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
        ];
    }
}
