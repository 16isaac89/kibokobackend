@extends('layouts.dealer')
@section('content')

<div class="card">
    <div class="card-header">
       <b style="color:black;font-size:20px;font-weight:bold;">{{$product->name}} Batches</b>
       @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
    </div>

<table  style="width:100%;">
	<tr>
		<td style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Stock</span></td>
		<td style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Selling Price</span></td>
		<th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Sold</span></th>
		<th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Batch</span></th>
		<th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Received at</span></th>
		<th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Expiry</span></th>
        <th style="background-color:grey;text-align:center;width:150px;"><span style="color:white;font-size:20px;font-weight:bold;">Cost</span></th>
		</tr>
</table>
<form method="post" action="{{route('dealer.save.cost')}}">
    <input type="hidden" name="productid" value="{{$product->id}}">
	@csrf
	<TABLE id="dataTable"  style="width:100%;">
    @foreach($product->stocks as $stock)
		<TR>
			<TD style="width:150px">
            <INPUT type="hidden" style="width:180px" value="{{$stock->id}}"  name="stocks[]" class="form-control productunit"/>
            <INPUT type="text" style="width:180px" value="{{$stock->amount}}" readonly  name="amount[]" class="form-control productunit"/>
        </TD>
            <TD style="width:150px"><INPUT type="text" style="width:180px" value="{{$stock->sellingprice}}"readonly  name="selling[]" class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="text" style="width:180px" value="{{$stock->sold}}"  readonly class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="text" style="width:180px" value="{{$stock->batch}}"  readonly name="price[]" class="form-control productprice"/></TD>
            <TD style="width:150px"><INPUT type="text" style="width:180px" value="{{$stock->receivedate}}"  readonly  class="form-control producttotal"/></TD>
            <TD style="width:150px"><INPUT type="text" style="width:180px" value="{{$stock->expirydate}}"  readonly  class="form-control productprice"/></TD>
            <TD style="width:150px"><INPUT type="text" style="width:180px" value="{{$stock->cost}}" max="{{$stock->sellingprice}}" name="costs[]"  required  class="form-control producttotal"/></TD>
		</TR>
        @endforeach
	</TABLE>
	<button class="btn btn-primary">Save</button>
</form>


        </div>


        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent




@endsection
