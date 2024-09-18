@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.performanceSetting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.performance-settings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="fromdate">{{ trans('cruds.performanceSetting.fields.fromdate') }}</label>
                <input class="form-control date {{ $errors->has('fromdate') ? 'is-invalid' : '' }}" type="text" name="fromdate" id="fromdate" value="{{ old('fromdate') }}">
                @if($errors->has('fromdate'))
                    <span class="text-danger">{{ $errors->first('fromdate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.performanceSetting.fields.fromdate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="todate">{{ trans('cruds.performanceSetting.fields.todate') }}</label>
                <input class="form-control date {{ $errors->has('todate') ? 'is-invalid' : '' }}" type="text" name="todate" id="todate" value="{{ old('todate') }}" required>
                @if($errors->has('todate'))
                    <span class="text-danger">{{ $errors->first('todate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.performanceSetting.fields.todate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="points">{{ trans('cruds.performanceSetting.fields.points') }}</label>
                <input class="form-control {{ $errors->has('points') ? 'is-invalid' : '' }}" type="number" name="points" id="points" value="{{ old('points', '0') }}" step="0.01">
                @if($errors->has('points'))
                    <span class="text-danger">{{ $errors->first('points') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.performanceSetting.fields.points_helper') }}</span>
            </div>

            <!-- <div class="form-group">
      <label for="inputState">Point Type</label>
      <select id="inputState" class="form-control" name="pointtype">
        <option selected value=" ">Choose type</option>
        <option value="createcustomer">Create Customer</option> 
        <option value="makesale">Make a Sale</option>
        <option value="reqstock">Request stock</option>
        <option value="returnreq">Stock return request</option>
      </select>
    </div> -->
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection