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
      <input type="number" id="stock" required name="stock" value="{{$item->stock}}" class="form-control" >
    </div>
    <div class="col-6">
    <label>Selling Price</label>
      <input type="number" id="sellingprice" required name="sellingprice" value="{{$item->sellingprice}}" class="form-control" >
    </div>
  </div>
  <div class="row" style="margin:10px;">
    <div class="col-6">
      <label>Efris Product Code:</label>
      <input type="text" id="efris_product_code" name="efris_product_code" class="form-control" >
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
