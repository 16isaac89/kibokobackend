<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\Admin\BookingResource;
use App\Models\Booking;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookingResource(Booking::with(['services', 'customer', 'drivers', 'car_type', 'rides', 'paymentmethod'])->get());
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create($request->all());
        $booking->services()->sync($request->input('services', []));
        $booking->drivers()->sync($request->input('drivers', []));
        $booking->rides()->sync($request->input('rides', []));

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookingResource($booking->load(['services', 'customer', 'drivers', 'car_type', 'rides', 'paymentmethod']));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());
        $booking->services()->sync($request->input('services', []));
        $booking->drivers()->sync($request->input('drivers', []));
        $booking->rides()->sync($request->input('rides', []));

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
