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
        
<form method="post" action="{{route('dealer.savereturn')}}">
      @csrf
      <input type="hidden" name="return" value="{{$return->id}}">
      <caption>List of items</caption>
	<TABLE id="dataTable"  style="width:100%;">
   
  <thead>
    <tr>
      <th scope="col">Item</th>
      <th scope="col">Return Request</th>
      <th scope="col">Approved</th>
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
            <TD style="width:150px"><INPUT type="number" readonly value="{{$item->qty_returned}}" required  name="unit[]" id="productunit" class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="number" readonly value="{{$item->approved_qty}}" class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="text" required   name="approved[]" class="form-control productprice"/></TD>
		</TR>
        @endforeach
</tbody>
	</TABLE>
@if($return->status === 'pending')
    <button type="submit" class="btn btn-primary">Save</button>
    @endif
</form>

      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
 
@endsection
@section('scripts')


@endsection