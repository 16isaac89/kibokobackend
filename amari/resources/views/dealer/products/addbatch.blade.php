@extends('layouts.dealer')
@section('styles')
    <style>
        .table td{
  position:relative;
}
    </style>
@endsection
@section('content')
@include('admin.dealers.modals.add')
@include('admin.dealers.modals.edit')

<div class="card">
    <div class="card-header">
       <b>ADD {{$product->name}} batch</b>
       @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    </div>

    <div class="card-body">

	<form method="post" action="{{route('dealer.product.saveaddbatch')}}">
		@csrf
        <input type="hidden" name="product" value="{{$product->id}}">
<table  style="margin:10px;width:100%;" class="table table-responsive">
	<tr>
		<th style="background-color:grey;text-align:center;width:50px;color:white;font-size:18;">Action</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:18;">Stock</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:18;">Selling Price</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:18;">Invoice</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:18;">Received at</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:18;">Expiry</th>
        <th style="background-color:grey;text-align:center;width:150px;color:white;font-size:18;">Cost</th>
        <th style="background-color:grey;text-align:center;width:150px;color:white;font-size:18;">Purchase Type</th>
		</tr>
</table>

	@csrf
	<TABLE id="dataTable" class="table table-responsive"  style="margin:10px;width:100%;">
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
			<TD style="width:50px">

			</TD>
            <TD><INPUT type="text" style="width:150px" required name="stocks" class="form-control"/></TD>
            <TD><INPUT type="text" style="width:150px" required  name="prices" class="form-control"/></TD>
            <TD><INPUT type="text" style="width:150px" required  name="invoices" class="form-control "/></TD>
            <TD><INPUT type="text" style="width:150px" required name="receivedate" class="form-control date"/></TD>
            <TD><INPUT type="text" style="width:150px" required  name="expiry" class="form-control date"/></TD>
            <TD><INPUT type="text" style="width:150px"  name="cost" class="form-control"/></TD>
            <td>

                <select class="form-control" name="purchase_type" required aria-label="Default select example">
                    <option selected value="">Select Purchase Type</option>
                    <option value="101">Import</option>
                    <option value="102">Local Purchase</option>
                    <option value="103">Manufacture/Assembling</option>
                  </select>
            </td>


		</TR>
	</TABLE>
	<button type="submit" class="btn btn-primary">Save</button>
</form>


        </div>


        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
$(document).ready(function () {
    $('.date').datetimepicker({
      format: 'YYYY-MM-DD',
      locale: 'en',
      icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
      }
    })
})
</script>
@endsection
