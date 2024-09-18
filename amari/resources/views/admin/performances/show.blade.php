@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.performance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.performances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.performance.fields.id') }}
                        </th>
                        <td>
                            {{ $performance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.performance.fields.user') }}
                        </th>
                        <td>
                            {{ $performance->user }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.performance.fields.points') }}
                        </th>
                        <td>
                            {{ $performance->points }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.performance.fields.type') }}
                        </th>
                        <td>
                            {{ $performance->type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.performances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection