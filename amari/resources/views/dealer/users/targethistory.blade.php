@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">

    <div class="card pd-20 pd-sm-40">
     
    @if($target)
      <div class="table-wrapper">
        @if($targettype === 'month')
      <form>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Date</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$target->month ?? ''}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Amount</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control" id="inputPassword" value="{{$target->money ?? ''}}">
    </div>
  </div>
</form>
    @else
    <form>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-4">Dates</label>
    <div class="col-4">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$target->fromdate ?? ''}}">
    </div>
    <div class="col-4">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$target->todate ?? ''}}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Amount</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control" id="inputPassword" value="{{$target->items->sum('total') ?? ''}}">
    </div>
  </div>
<div class="mt-5">
  <b>Targeted Items</b>
  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Target Qty</th>
      <th scope="col">Target Amount</th>
      <th scope="col">Sold</th>
    </tr>
  </thead>
  <tbody>
   @foreach($target->items as $item)
    <tr>
      <th scope="row">{{$item->product_name}}</th>
      <td>{{$item->selling_price}}</td>
      <td>{{$item->target_quantity}}</td>
      <td>{{$item->total}}</td>
      <td>{{$item->sold}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</table>
</form>
    @endif  
      </div><!-- table-wrapper -->
@else
<div class="alert alert-danger" role="alert">
 Nothing has been set for this month
</div>
@endif


    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
 
@endsection
@section('scripts')

@endsection