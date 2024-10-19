@extends('layouts.admin')
@section('content')
@include('admin.suppliers.modals.add')
<div class="card">

    <div class="card-body">
        <div class="table-responsive">
            <form method="POST" action="{{ route("admin.taxes.store") }}">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Name">
                  </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Value</label>
                  <input type="text" class="form-control" name="value" placeholder="Value">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent



@endsection
