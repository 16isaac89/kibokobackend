@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Edit Product
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <form method="post" action="{{route('admin.product.edit')}}">
        @csrf
   <div class="row" style="margin:10px;">
    <div class="col-6">
      <label>Product Name:</label>
      <input type="text" id="productname" name="productname" value="{{$product->name}}" class="form-control" >
    </div>
    <div class="col-6">
    <label>Product Code:</label>
      <input type="text" id="productcode" name="productcode" value="{{$product->code}}" class="form-control" >
    </div>
  </div>
  <input type="hidden" name="productid" value="{{$product->id}}" id="productid">
  <div class="row" style="margin:10px;">
    <!-- <div class="col-6">
    <label>Product Stock:</label>
      <input type="text" id="productstock" value="{{$product->stock}}" name="productstock" class="form-control" >
    </div> -->
    <div class="col-6">
    <label>Product Brand:</label>
      <select class="form-control form-control-lg" id="productbrandname" required="required" name="productbrandname">
      <option>Select product Brand</option>
      @foreach($brands as $brand)
        <option  value="{{$brand->id}}" {{ $product->brand_id === $brand->id ? 'selected' : '' }}>{{$brand->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="row" style="margin:10px;">

  <div class="col-6">
  <label>Product Unit:</label>
  <select class="form-control"  name="productunit" required="required">
          <option  disabled>Select product unit </option>
          @foreach($units as $unit)
          <option value="{{$unit->shortname}}" {{ $product->unit === $unit->shortname ? 'selected' : '' }}>{{$unit->name}}</option>
        @endforeach
       
        </select>
    </div>
    <div class="col-6">
    <label>Product Price:</label>
      <input type="text" id="productprice" name="productprice" value="{{$product->price}}" class="form-control">
    </div>
  </div>
  <div class="row">
  <div class="col-6">
  <!-- <div class="row" style="margin:10px;"> -->
    <label>Product supplier:</label>
      <select class="form-control form-control-lg" id="productbrandname" required="required" name="productsupplier">
      <option>Select product supplier</option>
      @foreach($suppliers as $supplier)
        <option  value="{{$supplier->id}}" {{ $product->supplier_id === $supplier->id ? 'selected' : '' }}>{{$supplier->name}}</option>
        @endforeach
      </select> 
  </div>
  <div class="col-6">
  <label>Product Category:</label>
      <select class="form-control form-control-lg" required="required" name="productcategory">
      <option>Select product Category</option>
      @foreach($categories as $category)
        <option value="{{$category->id}}" {{ $product->product_category_id === $category->id ? 'selected' : '' }}>{{$category->name}}</option>
        @endforeach
      </select>
    </div>
   
  <!-- <div class="col-12">
     <b>Product Variations</b>
    </div>
</div> -->
<!-- <INPUT type="button" class="btn btn-success" value="Add Row" onclick="addVRow('vdataTable')" />
<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteVRow('vdataTable')" />

<TABLE  width="350px" style="margin:10px;">
@if(count($product->variances)>0)
@foreach($product->variances as $variance)
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
        <TD><INPUT type="text" style="width:100px" value="{{$variance->name}}" name="vnames[]" class="form-control producttotal"/></TD>
        <TD><INPUT type="text" style="width:100px" value="{{$variance->quantity}}" name="vquantities[]" class="form-control producttotal"/></TD>
        <TD><INPUT type="text" style="width:100px" value="{{$variance->price}}" name="vprices[]" class="form-control producttotal"/></TD>
		</TR>
    @endforeach
    @endif
	</TABLE> -->


<!-- <TABLE id="vdataTable" width="350px" style="margin:10px;">
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
        <TD><INPUT type="text" style="width:100px" name="vnames[]" class="form-control producttotal" placeholder="Variance name"/></TD>
        <TD><INPUT type="text" style="width:100px" name="vquantities[]" class="form-control producttotal" placeholder="Variance Quantity"/></TD>
        <TD><INPUT type="text" style="width:100px" name="vprices[]" class="form-control producttotal" placeholder="Variance Price"/></TD>
		</TR>
	</TABLE> -->


	
</div>

<div class="row" style="margin:10px;">
<div class="col-4">
      <input type="text" name="categorycode" value="{{$product->category}}" required class="form-control" placeholder="Product Efris Category Code ">
    </div>
 
</div>

  <!-- <div class="col-6">
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
</div> -->


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