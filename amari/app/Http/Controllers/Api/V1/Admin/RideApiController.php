<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreRideRequest;
use App\Http\Requests\UpdateRideRequest;
use App\Http\Resources\Admin\RideResource;
use App\Models\Ride;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RideApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('ride_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RideResource(Ride::with(['category'])->get());
    }

    public function store(StoreRideRequest $request)
    {
        $ride = Ride::create($request->all());

        if ($request->input('photo', false)) {
            $ride->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($request->input('photos', false)) {
            $ride->addMedia(storage_path('tmp/uploads/' . basename($request->input('photos'))))->toMediaCollection('photos');
        }

        return (new RideResource($ride))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Ride $ride)
    {
        abort_if(Gate::denies('ride_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RideResource($ride->load(['category']));
    }

    public function update(UpdateRideRequest $request, Ride $ride)
    {
        $ride->update($request->all());

        if ($request->input('photo', false)) {
            if (!$ride->photo || $request->input('photo') !== $ride->photo->file_name) {
                if ($ride->photo) {
                    $ride->photo->delete();
                }
                $ride->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($ride->photo) {
            $ride->photo->delete();
        }

        if ($request->input('photos', false)) {
            if (!$ride->photos || $request->input('photos') !== $ride->photos->file_name) {
                if ($ride->photos) {
                    $ride->photos->delete();
                }
                $ride->addMedia(storage_path('tmp/uploads/' . basename($request->input('photos'))))->toMediaCollection('photos');
            }
        } elseif ($ride->photos) {
            $ride->photos->delete();
        }

        return (new RideResource($ride))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Ride $ride)
    {
        abort_if(Gate::denies('ride_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ride->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
