@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.permission.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.subscriptions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">Subscription Name</label>
                <input class="form-control" type="text" name="name" value="{{ old('name', '') }}" required>
            </div>
            <div class="form-group">
            <select class="form-control" required name="type"  aria-label="Default select example">
                <option selected value="">Select Type of Subscription</option>
                <option value="month">Monthly</option>
                <option value="year">Yearly</option>
              </select>
            </div>
            <div class="form-group">
                <label class="required" for="title">Days</label>
                <input class="form-control" type="text" name="days"  required>
            </div>
            <div class="form-group">
                <label class="required" for="title">Grace Period</label>
                <input class="form-control" type="text" name="grace_period"  required>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea3">Description</label>
                <textarea class="form-control" id="description" name="description" rows="7"></textarea>
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
