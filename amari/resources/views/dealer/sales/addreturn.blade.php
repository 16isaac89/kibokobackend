@extends('layouts.dealer')
@section('styles')
<style>
td.details-control {
    background: url('/images/logo/plus.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('/images/logo/minus.png') no-repeat center center;
}
</style>
@endsection
@section('content')
<div class="am-pagebody">
@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
<div class="card pd-20 pd-sm-40">
    <div class="card pd-5 pd-sm-20">
      <div class="row">

</div>
      <div class="table-wrapper">

<form method="post" action="{{route('dealer.saveadminreturn')}}">

      @csrf
      <input type="hidden" name="receipt" value="{{$return->id}}">
      <caption>List of items for receipt {{$return->id}}</caption><br/>
      <caption>Customer: {{$return->customer->name}}  </caption><br/>
      <caption>Route: {{$return->customer->route->name}}</caption><br/>
	<TABLE id="dataTable"  style="width:100%;">

  <thead>
    <tr>
      <th scope="col">Item</th>
      <th scope="col">Quantity</th>
      <th scope="col">Selling Price</th>
      <th scope="col">Verify</th>
    </tr>
  </thead>
  <tbody>
    @foreach($return->items as $item)
		<TR>
            <TD style="width:150px">
            <input type="hidden" value="{{$item->id}}" name="returns[]">
				<b>{{$item->product->name}}</b>
			</TD>
            <TD style="width:150px"><INPUT type="number" readonly value="{{$item->quantity}}" required  name="unit[]" id="productunit" class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="number" readonly value="{{$item->sellingprice}}" class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="number" required max="{{$item->quantity}}" min="0"   name="approved[]" class="form-control productprice"/></TD>
		</TR>
        @endforeach
</tbody>
	</TABLE>
    <button type="submit" class="btn btn-primary">Save</button>
</form>

      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->

@endsection
@section('scripts')


@endsection
