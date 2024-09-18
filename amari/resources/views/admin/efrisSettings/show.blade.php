@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.efrisSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.efris-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $efrisSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.aeskey') }}
                        </th>
                        <td>
                            {{ $efrisSetting->aeskey }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.tin') }}
                        </th>
                        <td>
                            {{ $efrisSetting->tin }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.deviceno') }}
                        </th>
                        <td>
                            {{ $efrisSetting->deviceno }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.keypath') }}
                        </th>
                        <td>
                            {{ $efrisSetting->keypath }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.efris-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection