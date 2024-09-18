@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.efrisSetting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.efris-settings.update", [$efrisSetting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="aeskey">{{ trans('cruds.efrisSetting.fields.aeskey') }}</label>
                <input class="form-control {{ $errors->has('aeskey') ? 'is-invalid' : '' }}" type="text" name="aeskey" id="aeskey" value="{{ old('aeskey', $efrisSetting->aeskey) }}">
                @if($errors->has('aeskey'))
                    <span class="text-danger">{{ $errors->first('aeskey') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.efrisSetting.fields.aeskey_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tin">{{ trans('cruds.efrisSetting.fields.tin') }}</label>
                <input class="form-control {{ $errors->has('tin') ? 'is-invalid' : '' }}" type="text" name="tin" id="tin" value="{{ old('tin', $efrisSetting->tin) }}">
                @if($errors->has('tin'))
                    <span class="text-danger">{{ $errors->first('tin') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.efrisSetting.fields.tin_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="deviceno">{{ trans('cruds.efrisSetting.fields.deviceno') }}</label>
                <input class="form-control {{ $errors->has('deviceno') ? 'is-invalid' : '' }}" type="text" name="deviceno" id="deviceno" value="{{ old('deviceno', $efrisSetting->deviceno) }}">
                @if($errors->has('deviceno'))
                    <span class="text-danger">{{ $errors->first('deviceno') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.efrisSetting.fields.deviceno_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="keypath">{{ trans('cruds.efrisSetting.fields.keypath') }}</label>
                <textarea class="form-control {{ $errors->has('keypath') ? 'is-invalid' : '' }}" name="keypath" id="keypath">{{ old('keypath', $efrisSetting->keypath) }}</textarea>
                @if($errors->has('keypath'))
                    <span class="text-danger">{{ $errors->first('keypath') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.efrisSetting.fields.keypath_helper') }}</span>
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