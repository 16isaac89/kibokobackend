@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
    @if (\Session::has('errors'))
    <div class="alert alert-warning">
        <ul>
            <li>{!! \Session::get('errors') !!}</li>
        </ul>
    </div>
@endif
@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
    </div>

    
    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

      <div class="row">
</div>
      <div class="table-wrapper">
       


      <div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Receipt/Invoice Items</h4>
                </div>

                <table class="table-responsive" style="margin:10px;width:100%;">
	<tr>
		<td style="background-color:orange;text-align:center;width:250px;">Item Name</td>
        <td style="background-color:orange;text-align:center;width:250px;">Price</td>
		<td style="background-color:orange;text-align:center;width:250px;">Quantity</td>
        <td style="background-color:orange;text-align:center;width:250px;">Total Sale</td>
		<th style="background-color:orange;text-align:center;width:250px;">Deduct</th>
        <th style="background-color:orange;text-align:center;width:250px;">Total Deduction</th>

		</tr>
        <form method="post" action="{{route('dealer.sales.notesform')}}">
            @csrf
            <input type="hidden" value="{{$sale->id}}" name="saleid">
</table>
                
                <TABLE class="table-responsive" id="dataTable" style="margin:10px;width:100%;">
                @foreach($sale->items as $item)
		<TR>
        <TD><INPUT type="hidden" name="product[]" value="{{$item->id}}"/>
        <span class="form-control productunit" style="width:200px">{{$item->name}}</span>
    </TD>
    <TD>
    <INPUT type="hidden"  value="{{$item->sellingprice}}" class="productcost"/>
        <span class="form-control" style="width:200px">{{$item->sellingprice}}</span>
    </TD>
            <TD><INPUT type="number" style="width:200px" readonly value="{{$item->quantity}}" class="form-control productunit"/></TD>
            <TD><INPUT type="number" style="width:150px" readonly value="{{$item->total}}" class="form-control "/></TD>
            <TD><INPUT type="number" style="width:100px" id="deductunit" min="0" max="{{$item->quantity}}" name="unit[]" class="form-control deductunit"/></TD>
            <TD><INPUT type="number" style="width:150px" id="totaldeduction" name="totaldeduction[]" class="form-control totaldeduction"/></TD>
		</TR>
        @endforeach
	</TABLE>
            </div>
        </div>    
    </div>

    <div class="row">
           
                <div class="col-6">
                    <label class="labels">Reason</label>
                    <select class="form-control" name="reasoncode">
                    <option selected>Select reason for credit note.</option>
                    <option value="101">Return of products due to expiry or damage</option>
                    <option value="102">Cancellation of the purchase.</option>
                    <option value="103">Invoice amount wrongly stated due to miscalculation of price, tax, or discounts.</option>
                    <option value="104">
                    Partial or complete waive 
off of the product sale after 
the invoice is generated and 
sent to customer.
                    </option>
                    <option value="105">Others</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="labels">Additional Details</label>
                    <textarea class="form-control" name="reasontext" id="exampleFormControlTextarea3" rows="7"></textarea>
                </div>
        
        </div>
</div>
<div class="mt-5 text-center"><button type="submit" class="btn btn-warning profile-button" type="button">Save Credit Note</button></div>
</form>
</div>
</div>
      </div><!-- table-wrapper -->
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	$('#dataTable').on('change click keyup input paste', '.deductunit', function() {
			var selectedValue = $(this).val();
			var row = $(this).closest('tr');
			var productprice = row.find('.productcost');
			var producttotal = row.find('.totaldeduction');
			let total = parseInt(selectedValue)*parseInt(productprice.val())
			producttotal.val(total)
			
	})
</script>
@endsection