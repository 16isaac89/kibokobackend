@extends('layouts.admin')
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" >
            Purchase Return
            </a>
        </div>
    </div>
@endcan
<form method="post" action="{{route('admin.purchase.return')}}">
<div class="card">
     <div class="card-header">
     @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
      <input type="hidden" value="{{$purchaseid}}" name="purchaseid">
            @csrf
        <div class="row">
      

    <div class="card-body">

        <div class="table-responsive">
        <table width="350px" style="margin:10px;width:100%;">
        <thead>
	<tr>
		<th class="text-center" style="background-color:grey;text-align:center;width:150px;">Product</th>
        <th class="text-center" style="background-color:grey;text-align:center;width:150px;">Price</th>
		<th class="text-center" style="background-color:grey;text-align:center;width:150px;">Units</th>
		<th class="text-center" style="background-color:grey;text-align:center;width:150px;">Received Units</th>
		<th class="text-center" style="background-color:grey;text-align:center;width:150px;">Received Price</th>
		<th class="text-center" style="background-color:grey;text-align:center;width:150px;">Expiry Date</th>
		<th class="text-center" style="background-color:grey;text-align:center;width:150px;">Return</th>
		
		</tr>
</thead>
</table>

	@csrf
    <TABLE style="margin:10px;width:100%;">
@foreach($purchaseorder->products as $product)
<TR>

    <TD  class="text-center">
        <SELECT name="products[]" id="productlist" required style="width:200px" class="form-control product">
        @foreach($products as $productss)
        <option value="{{ $product->id }}" {{$productss->id == $product->product_id ? 'selected' : '' }}>{{ $productss->name }}</option>
        @endforeach
        </SELECT>
    </TD>
    <TD class="text-center"><INPUT type="text" required style="width:150px" name="prices[]" value="{{$product->cost}}" class="form-control productprice"/></TD>
    <TD class="text-center"><INPUT type="text" required style="width:150px" name="units[]" value="{{$product->req_quantity}}" class="form-control productunit"/></TD>

	<TD class="text-center"><INPUT type="text" required style="width:150px" required placeholder="Received Quantity" value="{{$product->received_quantity}}" name="receivedunits[]" class="form-control"/></TD>
	<TD class="text-center"><INPUT type="text" required style="width:150px" required placeholder="Received Price" value="{{$product->actual}}" name="receivedprices[]" class="form-control"/></TD>
	<TD class="text-center"><INPUT type="text" required style="width:150px" required placeholder="Expiry Date" value="{{$product->expirydate}}" name="expirydates[]" class="form-control datetime"/></TD>
	<TD class="text-center"><INPUT type="number" value="0"  min="0" max="{{$product->received_quantity}}" required style="width:150px" required placeholder="Return Quantity" name="returnqtys[]" class="form-control"/></TD>
   
</TR>
@endforeach
</TABLE>

	<button type="submit" class="btn btn-primary">Save</button>

        </div>
    </div>
</div>
</form>



@endsection
@section('scripts')
@parent
<script language="javascript">
		function addRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}


			}
			}catch(e) {
				alert(e);
			}
		}

	</script>

	<script>
		$('#dataTable').on('change', '.brand', function() {
    var selectedValue = $(this).val();
    var row = $(this).closest('tr'); // get the row
    var stateSelect = row.find('.product'); // get the other select in the same row
    $.ajax({
		method:'GET',
        url: "{{route('dealer.brand.products')}}",
        data: { brand: selectedValue, "_token": "{{ csrf_token() }}" },
        success: function(response) {
			let data = response.products
            stateSelect.empty();
			stateSelect.append($('<option></option>').text("Select Product"));
            $.each(data, function(item, index) {
			
                stateSelect.append($('<option></option>').val(index.id).text(index.name));
            })
        },
		error:function(error){
			console.log(error)
		}
    });
})
		</script>

<script>
	$('#dataTable').on('change', '.product', function() {
			var selectedValue = $(this).val();

			var row = $(this).closest('tr'); // get the row
			var productunit = row.find('.productunit'); 
			var productprice = row.find('.productprice');
			var producttotal = row.find('.producttotal');
			$.ajax({
				method:'GET',
				url: "{{route('dealer.product.details')}}",
				data: { product: selectedValue, "_token": "{{ csrf_token() }}" },
				success: function(response) {
				let data = response.product
				productunit.val("1")
				productprice.val("")
				producttotal.val("")
				productprice.val(data.price)
				producttotal.val(parseInt("1")*parseInt(data.price))
				},
				error:function(error){
			console.log(error)
		}
		});
	})
	</script>

<script>
	$('#dataTable').on('change click keyup input paste', '.productunit', function() {
			var selectedValue = $(this).val();
			var row = $(this).closest('tr');
			var productprice = row.find('.productprice');
			var producttotal = row.find('.producttotal');
			let total = parseInt(selectedValue)*parseInt(productprice.val())
			producttotal.val(total)
			
	})
	</script>

@endsection