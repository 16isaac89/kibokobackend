<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCustomerPaymentRequest;
use App\Http\Requests\UpdateCustomerPaymentRequest;
use App\Http\Resources\Admin\CustomerPaymentResource;
use App\Models\CustomerPayment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerPaymentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('customer_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerPaymentResource(CustomerPayment::with(['received_by', 'paymentmethod', 'booking', 'customer', 'account'])->get());
    }

    public function store(StoreCustomerPaymentRequest $request)
    {
        $customerPayment = CustomerPayment::create($request->all());

        if ($request->input('proof', false)) {
            $customerPayment->addMedia(storage_path('tmp/uploads/' . basename($request->input('proof'))))->toMediaCollection('proof');
        }

        return (new CustomerPaymentResource($customerPayment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CustomerPayment $customerPayment)
    {
        abort_if(Gate::denies('customer_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerPaymentResource($customerPayment->load(['received_by', 'paymentmethod', 'booking', 'customer', 'account']));
    }

    public function update(UpdateCustomerPaymentRequest $request, CustomerPayment $customerPayment)
    {
        $customerPayment->update($request->all());

        if ($request->input('proof', false)) {
            if (!$customerPayment->proof || $request->input('proof') !== $customerPayment->proof->file_name) {
                if ($customerPayment->proof) {
                    $customerPayment->proof->delete();
                }
                $customerPayment->addMedia(storage_path('tmp/uploads/' . basename($request->input('proof'))))->toMediaCollection('proof');
            }
        } elseif ($customerPayment->proof) {
            $customerPayment->proof->delete();
        }

        return (new CustomerPaymentResource($customerPayment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CustomerPayment $customerPayment)
    {
        abort_if(Gate::denies('customer_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerPayment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
