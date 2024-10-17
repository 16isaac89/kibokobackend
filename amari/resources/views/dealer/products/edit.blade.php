@extends('layouts.dealer')
@section('content')

<div class="card">
    <div class="card-header">
       Edit Product
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <form method="post" action="{{route('update.dealer.product',$item->id)}}">
        @csrf
   <div class="row" style="margin:10px;">
    <div class="col-6">
      <label>Stock:</label>
      <input type="text" id="stock" name="stock" value="{{$item->stock}}" class="form-control" >
    </div>
    <div class="col-6">
    <label>Selling Price</label>
      <input type="text" id="sellingprice" name="sellingprice" value="{{$item->sellingprice}}" class="form-control" >
    </div>
  </div>
  <input type="hidden" name="productid" value="{{$product->id}}" id="productid">
  <button type="submit" style="margin:10px;" class="btn btn-primary">Submit</button>
</form>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent

@endsection
