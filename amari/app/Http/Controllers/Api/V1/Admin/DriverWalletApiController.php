<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverWalletRequest;
use App\Http\Requests\UpdateDriverWalletRequest;
use App\Http\Resources\Admin\DriverWalletResource;
use App\Models\DriverWallet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DriverWalletApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('driver_wallet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DriverWalletResource(DriverWallet::with(['paymentmethod', 'driver'])->get());
    }

    public function store(StoreDriverWalletRequest $request)
    {
        $driverWallet = DriverWallet::create($request->all());

        return (new DriverWalletResource($driverWallet))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DriverWallet $driverWallet)
    {
        abort_if(Gate::denies('driver_wallet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DriverWalletResource($driverWallet->load(['paymentmethod', 'driver']));
    }

    public function update(UpdateDriverWalletRequest $request, DriverWallet $driverWallet)
    {
        $driverWallet->update($request->all());

        return (new DriverWalletResource($driverWallet))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DriverWallet $driverWallet)
    {
        abort_if(Gate::denies('driver_wallet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $driverWallet->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
