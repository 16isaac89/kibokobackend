@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Product {{$product->name}} Stock Count

       @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <form method="post" action="{{route('admin.product.storecount')}}">
        @csrf
   <div class="row" style="margin:10px;">
    <div class="col-6">
      <label>Date:</label>
      <input type="text" id="period" name="period" required  class="form-control datetime" >
    </div>
    <div class="col-6">
    <label>General Stock Count:</label>
      <input type="number" id="amount" name="amount" required class="form-control" >
    </div>
  </div>

  <div class="row">

  <div class="col-6">
  <input type="hidden" name="productid" value="{{$product->id}}" id="productid">
<b style="margin:10px;font-size:18px;">Add Location Stock</b>
  <INPUT type="button" class="btn btn-success" value="Add Row" onclick="addRow('dataTable')" />

<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRow('dataTable')" />
 
    <TABLE id="dataTable" width="350px" style="margin:10px;">
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
			<TD style="width:150px">
				<SELECT name="locations[]" style="width:250px" required class="form-control brand">
                <option>Select product location</option>
                @foreach($locations as $brand)
					<OPTION value="{{$brand->id}}">{{$brand->name}}</OPTION>
                @endforeach 
				</SELECT>
			</TD>
            <TD><INPUT type="text" style="width:100px" name="quantities[]" required class="form-control producttotal"/></TD>
		</TR>
	</TABLE>
</div>

<div class="col-6">
<b style="margin:10px;font-size:18px;">Add Damages and Expireds</b>
<INPUT type="button" class="btn btn-success" value="Add Row" onclick="addRowdamage('dataTabledamage')" />
<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRowdamage('dataTabledamage')" />

<TABLE id="dataTabledamage" width="350px" style="margin:10px;">
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
			<TD style="width:150px">
			<select class="form-control" name="damagetype[]">
  <option selected>Select type of damage</option>
  <option value="damage">Damage</option>
  <option value="expired">Expired</option>
</select>
			</TD>
            <TD><input type="text" class="form-control" name="damagevalues[]" required ></TD>
		</TR>
	</TABLE>




<div class="form-group">
  <label for="exampleFormControlTextarea3">Comment</label>
  <textarea class="form-control" name="comment" required rows="7"></textarea>
</div>


  <button type="submit" style="margin:10px;" class="btn btn-primary">Submit</button>
</form>
        
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
		function addRowdamage(tableID) {

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

		function deleteRowdamage(tableID) {
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