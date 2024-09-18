@extends('layouts.admin')
@section('content')
@include('admin.dealers.modals.add')
@include('admin.dealers.modals.edit')

<div class="card">
    <div class="card-header">
       ADD NEW DISPATCH
    </div>

    <div class="card-body">
       <INPUT type="button" class="btn btn-success" value="Add Row" onclick="addRow('dataTable')" />

	<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRow('dataTable')" />

	<form method="post" action="{{route('admin.dispatch.savecopy')}}">
		<div class="row my-1">
			<label class="mr-sm-2" for="inlineFormCustomSelect">Dealer</label>
			<select class="custom-select mr-sm-2" name="dealer" value={{$dealer}}>
			  <option selected>Choose dealer.</option>
			  @foreach ($dealers as $dealer)
			  <option value="{{$dealer->id}}" {{$dealer->id == $dealer->id ? 'selected' : '' }}>{{$dealer->tradename}} {{$dealer->phonenumber}}</option>
			  @endforeach
			 
			</select>
		  </div>
<table width="350px" style="margin:10px;width:850px;">
	<tr>
		<td style="background-color:grey;text-align:center;width:150px;">Action</td>
		<td style="background-color:grey;text-align:center;width:150px;">Brand</td>
		<th style="background-color:grey;text-align:center;width:150px;">Product</th>
		<th style="background-color:grey;text-align:center;width:150px;">Units</th>
		<th style="background-color:grey;text-align:center;width:150px;">Price</th>
		<th style="background-color:grey;text-align:center;width:150px;">Total</th>
		</tr>
</table>

	@csrf
	<TABLE id="dataTable" width="350px" style="margin:10px;">
    @foreach($items as $item)
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
			<TD style="width:150px">
				<SELECT name="brands[]"   style="width:250px" class="form-control brand">
                <option>Select product brand</option>
                @foreach($brands as $brand)
					<OPTION value="{{$brand->id}}" {{$item->brand == $brand->id ? 'selected' : '' }}>{{$brand->name}}</OPTION>
                @endforeach
				</SELECT>
			</TD>
            <TD style="width:150px">
				<SELECT name="products[]" id="productlist" style="width:250px" class="form-control product">
					@foreach($products as $product)
                    <OPTION value="{{$product->id}}" {{$item->product_id == $product->id ? 'selected' : '' }}>{{$product->name}}</OPTION>
                    @endforeach
				</SELECT>
			</TD>
            <TD><INPUT type="text" style="width:100px" value="{{$item->quantity}}" name="unit[]" class="form-control productunit"/></TD>
            <TD><INPUT type="text" style="width:100px" value="{{$item->price/$item->quantity}}" readonly name="price[]" class="form-control productprice"/></TD>
            <TD><INPUT type="text" style="width:100px" readonly name="total[]" value="{{$item->price}}" class="form-control producttotal"/></TD>

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
        url: "{{route('admin.brand.products')}}",
        data: { brand: selectedValue, "_token": "{{ csrf_token() }}" },
        success: function(response) {
			let data = response.products
            stateSelect.empty();
			stateSelect.append($('<option></option>').text("Select Product"));
            $.each(data, function(item, index) {
			
                stateSelect.append($('<option></option>').val(index.id).text(index.name));
            })
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
				url: "{{route('admin.product.details')}}",
				data: { product: selectedValue, "_token": "{{ csrf_token() }}" },
				success: function(response) {
				let data = response.product
				productunit.val("1")
				productprice.val("")
				producttotal.val("")
				productprice.val(data.price)
				producttotal.val(parseInt("1")*parseInt(data.price))
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