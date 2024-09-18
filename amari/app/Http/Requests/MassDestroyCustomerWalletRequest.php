<?php

namespace App\Http\Requests;

use App\Models\CustomerWallet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCustomerWalletRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('customer_wallet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:customer_wallets,id',
        ];
    }
}
