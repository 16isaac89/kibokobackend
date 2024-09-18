@extends('layouts.admin')
@section('content')

@can('suppliers_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" data-toggle="modal" data-target="#addunit">
               ADD
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
        <form class="row g-3" method="post" action="{{route('admin.productunits.storeunit')}}">
            @csrf
 
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" required id="name">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Short Name</label>
    <input type="text" class="form-control" name="shortname" required id="shortname">
  </div>
      </div>
        <button type="submit" class="btn btn-primary">Send message</button>
        </form>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent

@endsection