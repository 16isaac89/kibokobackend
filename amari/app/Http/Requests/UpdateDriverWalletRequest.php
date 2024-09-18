<?php

namespace App\Http\Requests;

use App\Models\DriverWallet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDriverWalletRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('driver_wallet_edit');
    }

    public function rules()
    {
        return [
            'amount' => [
                'required',
            ],
            'date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'driver_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
