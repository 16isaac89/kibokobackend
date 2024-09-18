<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExtraRequest;
use App\Http\Requests\UpdateExtraRequest;
use App\Http\Resources\Admin\ExtraResource;
use App\Models\Extra;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtrasApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('extra_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExtraResource(Extra::all());
    }

    public function store(StoreExtraRequest $request)
    {
        $extra = Extra::create($request->all());

        return (new ExtraResource($extra))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Extra $extra)
    {
        abort_if(Gate::denies('extra_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExtraResource($extra);
    }

    public function update(UpdateExtraRequest $request, Extra $extra)
    {
        $extra->update($request->all());

        return (new ExtraResource($extra))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Extra $extra)
    {
        abort_if(Gate::denies('extra_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extra->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
