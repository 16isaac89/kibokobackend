<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEfrisSettingRequest;
use App\Http\Requests\StoreEfrisSettingRequest;
use App\Http\Requests\UpdateEfrisSettingRequest;
use App\Models\EfrisSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EfrisSettingController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('efris_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $efrisSettings = EfrisSetting::all();

        return view('admin.efrisSettings.index', compact('efrisSettings'));
    }

    public function create()
    {
        abort_if(Gate::denies('efris_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.efrisSettings.create');
    }

    public function store(StoreEfrisSettingRequest $request)
    {
        $efrisSetting = EfrisSetting::create($request->all());

        return redirect()->route('admin.efris-settings.index');
    }

    public function edit(EfrisSetting $efrisSetting)
    {
        abort_if(Gate::denies('efris_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.efrisSettings.edit', compact('efrisSetting'));
    }

    public function update(UpdateEfrisSettingRequest $request, EfrisSetting $efrisSetting)
    {
        $efrisSetting->update($request->all());

        return redirect()->route('admin.efris-settings.index');
    }

    public function show(EfrisSetting $efrisSetting)
    {
        abort_if(Gate::denies('efris_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.efrisSettings.show', compact('efrisSetting'));
    }

    public function destroy(EfrisSetting $efrisSetting)
    {
        abort_if(Gate::denies('efris_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $efrisSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyEfrisSettingRequest $request)
    {
        EfrisSetting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
