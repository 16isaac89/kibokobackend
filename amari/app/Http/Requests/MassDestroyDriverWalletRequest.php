<?php

namespace App\Http\Requests;

use App\Models\DriverWallet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDriverWalletRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('driver_wallet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:driver_wallets,id',
        ];
    }
}
