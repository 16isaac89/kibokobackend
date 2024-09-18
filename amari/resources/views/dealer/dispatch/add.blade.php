@extends('layouts.dealer')
@section('content')
@include('admin.dealers.modals.add')
@include('admin.dealers.modals.edit')

<div class="card">
	@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif

    <div class="card-body">
       <INPUT type="button" class="btn btn-success" value="Add Row" onclick="addRow('dataTable')" />

	<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRow('dataTable')" />





	<form method="post" action="{{route('dealer.topup.store')}}">
        <input type="hidden" value="{{$dispatch->id}}" name="dispatch">
        <input type="hidden" value="{{$dispatch->van->id}}" name="vanid">
		<div class="col" style="margin-top:10px;">
			<label class="mr-sm-2" style="font-size: 18px;" for="inlineFormCustomSelect">{{$dispatch->van->name}}</label>
		  </div>
<table width="350px" style="margin:10px;width:100%">
	<tr>
		<td style="background-color:grey;text-align:center;width:150px;color:white;font-size:20px;">Action</td>
		<td style="background-color:grey;text-align:center;width:150px;color:white;font-size:20px;">Brand</td>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:20px;">Product</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:20px;">Batch</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:20px;">Units</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:20px;">Price</th>
		<th style="background-color:grey;text-align:center;width:150px;color:white;font-size:20px;">Total</th>
		</tr>
</table>
<table style="margin:10px;width:100%">

  @foreach($dispatch->dispatchproducts as $item)
    <TR>
    <td style="text-align:center;width:150px;"></td>
			<TD style="text-align:center;width:150px;">
            {{$item->brandname}}
			</TD>
            <TD style="text-align:center;width:150px;">
            {{$item->name}}
			</TD>
			<TD style="text-align:center;width:150px;">
			<!-- Exp: {{$item->batchstock->expirydate ?? ''}}</br> -->
			Stock: {{$item->batchstock->amount ?? ''}}</br>
			Price: {{$item->batchstock->sellingprice ?? ''}}

		</TD>
            <TD style="text-align:center;width:150px;">{{$item->dispatchedquantity}}</TD>
            <TD style="text-align:center;width:150px;">{{$item->price}}</TD>
            <TD style="text-align:center;width:150px;">{{$item->price*$item->quantity}}</TD>


		</TR>
    @endforeach

</table>

	@csrf
	<table id="dataTable"  style="margin-top:10px;width:100%">
		<TR>
        <TD><INPUT type="checkbox" name="chk" style="width:150px"/></TD>
			<TD style="width:150px">
				<SELECT name="brands[]" style="width:150px"  class="form-control brand">
                <option>Select product brand</option>
                @foreach($brands as $brand)
					<OPTION value="{{$brand->id}}">{{$brand->name}}</OPTION>
                @endforeach
				</SELECT>
			</TD>
            <TD style="width:150px">
				<SELECT name="products[]" id="productlist" class="form-control product">

				</SELECT>
			</TD>
			<TD style="width:150px">
				<SELECT name="batches[]" id="batchlist" class="form-control batch">

				</SELECT>
			</TD>
            <TD style="width:150px"><INPUT type="text"  name="unit[]" class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="text"  readonly name="price[]" class="form-control productprice"/></TD>
            <TD style="width:150px"><INPUT type="text"  readonly name="total[]" class="form-control producttotal"/></TD>

		</TR>
</table>
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
        url: "{{route('dealer.brand.products')}}",
        data: { brand: selectedValue, "_token": "{{ csrf_token() }}" },
        success: function(response) {
			let data = response.products
            stateSelect.empty();
			stateSelect.append($('<option></option>').text("Select Product"));
            $.each(data, function(item, index) {
console.log(index.id)
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
		$('#dataTable').on('change', '.batch', function() {
    var selectedValue = $(this).val();

	var row = $(this).closest('tr'); // get the row
			var productunit = row.find('.productunit');
			var productprice = row.find('.productprice');
			var producttotal = row.find('.producttotal');
	$.ajax({
				method:'GET',
				url: "{{route('dealer.batch.price')}}",
				data: { batch: selectedValue, "_token": "{{ csrf_token() }}" },
				success: function(response) {
				let data = response.batch
				console.log("data")
				console.log(data)
				productunit.val("1")
				productprice.val("")
				producttotal.val("")
				productprice.val(data.sellingprice)
				producttotal.val(parseInt("1")*parseInt(data.sellingprice))
				},
				error:function(error){
			console.log(error)
		}
		});
console.log(selectedValue)
})
		</script>
<script>
		$('#dataTable').on('change', '.product', function() {
    var selectedValue = $(this).val();
	console.log("selectedValue")
	console.log(selectedValue)
    var row = $(this).closest('tr'); // get the row
    var stateSelect = row.find('.batch'); // get the other select in the same row
    $.ajax({
		method:'GET',
        url: "{{route('dealer.product.batch')}}",
        data: { product: selectedValue, "_token": "{{ csrf_token() }}" },
        success: function(response) {
            console.log(selectedValue)
			let data = response.batches
            stateSelect.empty();
			stateSelect.append($('<option></option>').text("Select Product Batch"));
            $.each(data, function(item, index) {
                stateSelect.append($('<option></option>').val(index.id).text(index.amount+' '+index.sellingprice+' '+index.expirydate));
            })
        },
		error:function(error){
			console.log(error)
		}
    });
})
		</script>
<!-- <script>
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
	</script> -->

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
