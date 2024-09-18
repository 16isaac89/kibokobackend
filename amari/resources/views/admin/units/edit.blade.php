@extends('layouts.admin')
@section('content')
@include('admin.suppliers.modals.add')
@can('suppliers_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <!-- <a class="btn btn-success" data-toggle="modal" data-target="#addsupplier">
               ADD
            </a> -->
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        <b style="color:black;font-size:25px;">Edit {{$unit->name}}</b>
</div>
    <div class="card-body">
        <div class="table-responsive">
        <form class="row g-3" method="post" action="{{route('admin.units.update')}}">
            @csrf
            <input type="hidden" name="unit" value="{{$unit->id}}">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Name</label>
    <input type="text" class="form-control" value="{{$unit->name}}" required name="name" >
  </div>
 
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Short Name</label>
    <input type="text" class="form-control" value="{{$unit->shortname}}" name="shortname" required>
  </div>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send message</button>
        </form>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent

@endsection