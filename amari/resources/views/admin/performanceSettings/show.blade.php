@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.performanceSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.performance-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $performanceSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.fromdate') }}
                        </th>
                        <td>
                            {{ $performanceSetting->fromdate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.todate') }}
                        </th>
                        <td>
                            {{ $performanceSetting->todate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.points') }}
                        </th>
                        <td>
                            {{ $performanceSetting->points }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.pointtype') }}
                        </th>
                        <td>
                            {{ $performanceSetting->pointtype }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.performance-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection