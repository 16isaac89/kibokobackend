<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreRideCategoryRequest;
use App\Http\Requests\UpdateRideCategoryRequest;
use App\Http\Resources\Admin\RideCategoryResource;
use App\Models\RideCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RideCategoryApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('ride_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RideCategoryResource(RideCategory::all());
    }

    public function store(StoreRideCategoryRequest $request)
    {
        $rideCategory = RideCategory::create($request->all());

        if ($request->input('photo', false)) {
            $rideCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        return (new RideCategoryResource($rideCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RideCategory $rideCategory)
    {
        abort_if(Gate::denies('ride_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RideCategoryResource($rideCategory);
    }

    public function update(UpdateRideCategoryRequest $request, RideCategory $rideCategory)
    {
        $rideCategory->update($request->all());

        if ($request->input('photo', false)) {
            if (!$rideCategory->photo || $request->input('photo') !== $rideCategory->photo->file_name) {
                if ($rideCategory->photo) {
                    $rideCategory->photo->delete();
                }
                $rideCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($rideCategory->photo) {
            $rideCategory->photo->delete();
        }

        return (new RideCategoryResource($rideCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RideCategory $rideCategory)
    {
        abort_if(Gate::denies('ride_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rideCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
