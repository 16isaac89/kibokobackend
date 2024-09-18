@extends('layouts.dealer')
@section('content')
<div class="am-pagebody">

    <div class="card pd-20 pd-sm-40">
	<b>{{$user->phone}} {{$user->username}}</b><br/>
	{{-- <b>Target \type: {{$user->targettype}}</b><br/> --}}
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
      <div class="table-wrapper">
      {{-- @if($user->targettype === 'month') --}}
      <div id="monthtarget" style="margin:10px;">
      <b>Set target by Month</b>
      <form method="POST" action="{{route('salertargets.store')}}">
              @csrf
              <input type="hidden" name="user" value="{{$user->id}}">
              <div class="form-row mt-2">
                <div class="col">
                <div class="row">
<div class="col-6">
                    <input type="text" class="form-control month" id="month" name="month" placeholder="Select month">
                  </div>
				  <div class="col-6">
                    <input type="text" class="form-control year" id="year" name="year" placeholder="Select year">
                  </div>
                  <!-- <div class="col-6">
                    <input type="text" class="form-control month" id="month" name="todate" placeholder="To Date">
                  </div> -->
</div>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" name="money" placeholder="Amount">
                  </div>
                 
                </div>
                <input type="hidden" id="userid" name="userid" value='{{$user->id}}'>
                <button type="submit" class="btn btn-primary mt-2">Save</button>
            </form>


      </div>
	  {{-- @else
      <div id="skutarget" class="col" style="margin-top:10px;">
      <b>Set target by SKU</b>
      <INPUT type="button" class="btn btn-success" value="Add Row" onclick="addRow('dataTable')" />

<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRow('dataTable')" />
<div class="row">
    <form method="post" action="{{route('dealer.sku.target')}}">
    <input type="hidden" name="user" value="{{$user->id}}">
    <div class="row" style="margin:10px;" >
	<div class="col-6">
                    <input type="text" class="form-control month" id="fromdate" name="fromdate" placeholder="Select From Date">
                  </div>
				  <div class="col-6">
                    <input type="text" class="form-control month" id="todate" name="todate" placeholder="Select To Date">
                  </div>
                  <!-- <div class="col-6">
                    <input type="text" class="form-control month" id="month" name="todate" placeholder="To Date">
                  </div> -->
</div>
</div>
<table  style="margin:10px;width:100%;">
	<tr>
		<td >Action</td>
		<td style="text-align:center;width:150px;">Brand</td>
		<th style="text-align:center;width:150px;">Product</th>
		<th style="text-align:center;width:150px;">Batch</th>
		<th style="text-align:center;width:150px;">Units</th>
		<th style="text-align:center;width:150px;">Price</th>
		<th style="text-align:center;width:150px;">Total</th>
		</tr>
</table>

	@csrf
	<TABLE id="dataTable"  style="margin:10px;width:100%;">
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
			<TD style="width:150px;text-align:center;">
				<SELECT name="brands[]" class="form-control brand" required="required">
                <option>Select product brand</option>
                @foreach($brands as $brand)
					<OPTION value="{{$brand->id}}">{{$brand->name}}</OPTION>
                @endforeach
				</SELECT>
			</TD>
            <TD style="width:150px">
				<SELECT name="products[]" id="productlist" required="required" class="form-control product">
					
				</SELECT>
			</TD>
			<TD style="width:150px">
				<SELECT name="batches[]" id="batchlist" required="required" class="form-control batch">
					
				</SELECT>
			</TD>
            <TD style="width:150px"><INPUT type="number" required  name="unit[]" id="productunit" class="form-control productunit"/></TD>
            <TD style="width:150px"><INPUT type="text"  readonly name="price[]" class="form-control productprice"/></TD>
            <TD style="width:150px"><INPUT type="text"  readonly name="total[]" class="form-control producttotal"/></TD>

		</TR>
	</TABLE>
	<button class="btn btn-primary">Save</button>
</form>
      </div>
      @endif --}}
      </div><!-- table-wrapper -->
    </div><!-- card -->

      </div><!-- table-wrapper -->
    </div><!-- card -->

  </div><!-- am-pagebody -->
 
@endsection
@section('scripts')
<script>
//   (function() {
//     $('.month').datetimepicker({
//     format: 'YYYY-MM-DD',
//     locale: 'en',
//     sideBySide: true,
//     icons: {
//       up: 'fas fa-chevron-up',
//       down: 'fas fa-chevron-down',
//       previous: 'fas fa-chevron-left',
//       next: 'fas fa-chevron-right'
//     }
//   })
//   })();
  </script>
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


{{-- <script>
	$('#dataTable').on('change click keyup input paste', '.productunit', function() {
			var selectedValue = $(this).val();
			var row = $(this).closest('tr');
			var productprice = row.find('.productprice');
			var producttotal = row.find('.producttotal');
			let total = parseInt(selectedValue)*parseInt(productprice.val())
			producttotal.val(total)
			
	})
	</script> --}}
	    <script>
			$('.month').datetimepicker({
	 format: 'MM',
	 locale: 'en',
	 icons: {
	   up: 'fas fa-chevron-up',
	   down: 'fas fa-chevron-down',
	   previous: 'fas fa-chevron-left',
	   next: 'fas fa-chevron-right'
	 }
   })
   
	 $('.year').datetimepicker({
	 format: 'YYYY',
	 locale: 'en',
	 icons: {
	   up: 'fas fa-chevron-up',
	   down: 'fas fa-chevron-down',
	   previous: 'fas fa-chevron-left',
	   next: 'fas fa-chevron-right'
	 }
   })
		 </script>
@endsection