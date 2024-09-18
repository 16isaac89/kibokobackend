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
        <b style="color:black;font-size:25px;">Edit {{$supplier->name}}</b>
</div>
    <div class="card-body">
        <div class="table-responsive">
        <form class="row g-3" method="post" action="{{route('admin.suppliers.edit')}}">
            @csrf
            <input type="hidden" name="supplier" value="{{$supplier->id}}">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">TIN</label>
    <input type="text" class="form-control" value="{{$supplier->tin}}" required name="tin" id="tin">
  </div>
  <div class="col-md-4">
  <a type="button" class="btn btn-secondary" href="{{route('admin.suppliers.checktin',['tin'=>'1000089262'])}}">Get Info</a>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Name</label>
    <input type="text" class="form-control" value="{{$supplier->name}}" name="name" required id="name">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Phone</label>
    <input type="text" class="form-control" name="phone" value="{{$supplier->phone}}" required id="phone">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Email</label>
    <input type="text" class="form-control"required id="email" value="{{$supplier->email}}" name="email">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Address</label>
    <input type="text" class="form-control" required id="address" value="{{$supplier->address}}" name="address">
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