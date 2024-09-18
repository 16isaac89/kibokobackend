@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">
    <div class="card pd-20 pd-sm-40">
      <div class="table-wrapper">
        <form method="POST" action="{{ route("dealersuppliers.update", [$supplier->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

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

      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')

@endsection
