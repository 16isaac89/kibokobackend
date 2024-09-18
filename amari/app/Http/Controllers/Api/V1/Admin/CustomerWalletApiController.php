<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerWalletRequest;
use App\Http\Requests\UpdateCustomerWalletRequest;
use App\Http\Resources\Admin\CustomerWalletResource;
use App\Models\CustomerWallet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerWalletApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_wallet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerWalletResource(CustomerWallet::with(['customer'])->get());
    }

    public function store(StoreCustomerWalletRequest $request)
    {
        $customerWallet = CustomerWallet::create($request->all());

        return (new CustomerWalletResource($customerWallet))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CustomerWallet $customerWallet)
    {
        abort_if(Gate::denies('customer_wallet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerWalletResource($customerWallet->load(['customer']));
    }

    public function update(UpdateCustomerWalletRequest $request, CustomerWallet $customerWallet)
    {
        $customerWallet->update($request->all());

        return (new CustomerWalletResource($customerWallet))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CustomerWallet $customerWallet)
    {
        abort_if(Gate::denies('customer_wallet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerWallet->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
