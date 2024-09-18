<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreZoneRideRequest;
use App\Http\Requests\UpdateZoneRideRequest;
use App\Http\Resources\Admin\ZoneRideResource;
use App\Models\ZoneRide;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ZoneRideApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('zone_ride_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ZoneRideResource(ZoneRide::with(['zone'])->get());
    }

    public function store(StoreZoneRideRequest $request)
    {
        $zoneRide = ZoneRide::create($request->all());

        return (new ZoneRideResource($zoneRide))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ZoneRide $zoneRide)
    {
        abort_if(Gate::denies('zone_ride_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ZoneRideResource($zoneRide->load(['zone']));
    }

    public function update(UpdateZoneRideRequest $request, ZoneRide $zoneRide)
    {
        $zoneRide->update($request->all());

        return (new ZoneRideResource($zoneRide))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ZoneRide $zoneRide)
    {
        abort_if(Gate::denies('zone_ride_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $zoneRide->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
