<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPerformanceRequest;
use App\Http\Requests\StorePerformanceRequest;
use App\Http\Requests\UpdatePerformanceRequest;
use App\Models\Performance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerformanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('performance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $performances = Performance::all();

        return view('admin.performances.index', compact('performances'));
    }

    public function create()
    {
        abort_if(Gate::denies('performance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.performances.create');
    }

    public function store(StorePerformanceRequest $request)
    {
        $performance = Performance::create($request->all());

        return redirect()->route('admin.performances.index');
    }

    public function edit(Performance $performance)
    {
        abort_if(Gate::denies('performance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.performances.edit', compact('performance'));
    }

    public function update(UpdatePerformanceRequest $request, Performance $performance)
    {
        $performance->update($request->all());

        return redirect()->route('admin.performances.index');
    }

    public function show(Performance $performance)
    {
        abort_if(Gate::denies('performance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.performances.show', compact('performance'));
    }

    public function destroy(Performance $performance)
    {
        abort_if(Gate::denies('performance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $performance->delete();

        return back();
    }

    public function massDestroy(MassDestroyPerformanceRequest $request)
    {
        Performance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
