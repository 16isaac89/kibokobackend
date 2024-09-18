<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMapRequest;
use App\Http\Requests\StoreMapRequest;
use App\Http\Requests\UpdateMapRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Sale;

class MapController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('map_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sales = Sale::with('dealer','user','van','route','items','customer')->get();
        return view('admin.maps.index')->with('sales',$sales);
    }

    public function create()
    {
        abort_if(Gate::denies('map_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.maps.create');
    }

    public function store(StoreMapRequest $request)
    {
        $map = Map::create($request->all());

        return redirect()->route('admin.maps.index');
    }

    public function edit(Map $map)
    {
        abort_if(Gate::denies('map_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.maps.edit', compact('map'));
    }

    public function update(UpdateMapRequest $request, Map $map)
    {
        $map->update($request->all());

        return redirect()->route('admin.maps.index');
    }

    public function show(Map $map)
    {
        abort_if(Gate::denies('map_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.maps.show', compact('map'));
    }

    public function destroy(Map $map)
    {
        abort_if(Gate::denies('map_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $map->delete();

        return back();
    }

    public function massDestroy(MassDestroyMapRequest $request)
    {
        Map::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
