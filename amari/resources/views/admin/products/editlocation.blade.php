@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       <b style="font-size:25px;color:black;">Edit {{$product->name}} Locations</b>
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <form method="post" action="{{route('admin.product.saveeditlocation')}}">
        @csrf
  <input type="hidden" name="productid" value="{{$product->id}}">

  <div class="col-6">
<div class="row" style="margin:10px;">
  <div class="col-12">
     <b>Product Locations</b>
    </div>
</div>
  <INPUT type="button" class="btn btn-success" value="Add Row" onclick="addRow('dataTable')" />

<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRow('dataTable')" />
<TABLE  width="350px" style="margin:10px;">
@if(count($product->locationproducts)>0)
@foreach($product->locationproducts as $plocation)
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
			<TD style="width:150px">
				<SELECT name="locations[]" style="width:250px" class="form-control brand">
                <option>Select product location</option>
                @foreach($locations as $location)
					<OPTION value="{{$location->id}}" {{ $plocation->location_id === $location->id ? 'selected' : '' }}>{{$location->name}}</OPTION>
                @endforeach 
				</SELECT>
			</TD>
            <TD><INPUT type="text" style="width:100px" name="quantities[]" value="{{$plocation->quantity}}" class="form-control producttotal"/></TD>
		</TR>
        @endforeach
        @endif
	</TABLE>
    <TABLE id="dataTable" width="350px" style="margin:10px;">
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
			<TD style="width:150px">
				<SELECT name="locations[]" style="width:250px" class="form-control brand">
                <option>Select product location</option>
                @foreach($locations as $brand)
					<OPTION value="{{$brand->id}}">{{$brand->name}}</OPTION>
                @endforeach 
				</SELECT>
			</TD>
            <TD><INPUT type="text" style="width:100px" name="quantities[]" class="form-control producttotal"/></TD>
		</TR>
	</TABLE>
</div>
</div>
  <button type="submit" style="margin:10px;" class="btn btn-primary">Submit</button>
</form>
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


<script language="javascript">
		function addVRow(tableID) {

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

		function deleteVRow(tableID) {
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

@endsection