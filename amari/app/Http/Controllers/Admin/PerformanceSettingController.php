<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPerformanceSettingRequest;
use App\Http\Requests\StorePerformanceSettingRequest;
use App\Http\Requests\UpdatePerformanceSettingRequest;
use App\Models\PerformanceSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerformanceSettingController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('performance_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $performanceSettings = PerformanceSetting::all();

        return view('admin.performanceSettings.index', compact('performanceSettings'));
    }

    public function create()
    {
        abort_if(Gate::denies('performance_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.performanceSettings.create');
    }

    public function store(StorePerformanceSettingRequest $request)
    {
        $performanceSetting = PerformanceSetting::create($request->all());

        return redirect()->route('admin.performance-settings.index');
    }

    public function edit(PerformanceSetting $performanceSetting)
    {
        abort_if(Gate::denies('performance_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.performanceSettings.edit', compact('performanceSetting'));
    }

    public function update(UpdatePerformanceSettingRequest $request, PerformanceSetting $performanceSetting)
    {
        $performanceSetting->update($request->all());

        return redirect()->route('admin.performance-settings.index');
    }

    public function show(PerformanceSetting $performanceSetting)
    {
        abort_if(Gate::denies('performance_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.performanceSettings.show', compact('performanceSetting'));
    }

    public function destroy(PerformanceSetting $performanceSetting)
    {
        abort_if(Gate::denies('performance_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $performanceSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyPerformanceSettingRequest $request)
    {
        PerformanceSetting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
