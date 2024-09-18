@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.performanceSetting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.performance-settings.update", [$performanceSetting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="fromdate">{{ trans('cruds.performanceSetting.fields.fromdate') }}</label>
                <input class="form-control date {{ $errors->has('fromdate') ? 'is-invalid' : '' }}" type="text" name="fromdate" id="fromdate" value="{{ old('fromdate', $performanceSetting->fromdate) }}">
                @if($errors->has('fromdate'))
                    <span class="text-danger">{{ $errors->first('fromdate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.performanceSetting.fields.fromdate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="todate">{{ trans('cruds.performanceSetting.fields.todate') }}</label>
                <input class="form-control date {{ $errors->has('todate') ? 'is-invalid' : '' }}" type="text" name="todate" id="todate" value="{{ old('todate', $performanceSetting->todate) }}" required>
                @if($errors->has('todate'))
                    <span class="text-danger">{{ $errors->first('todate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.performanceSetting.fields.todate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="points">{{ trans('cruds.performanceSetting.fields.points') }}</label>
                <input class="form-control {{ $errors->has('points') ? 'is-invalid' : '' }}" type="number" name="points" id="points" value="{{ old('points', $performanceSetting->points) }}" step="0.01">
                @if($errors->has('points'))
                    <span class="text-danger">{{ $errors->first('points') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.performanceSetting.fields.points_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection