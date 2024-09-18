<!-- Modal -->
<div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="addproductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addproductModalLabel">Product Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.products.store')}}">
        @csrf
  <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="text" name="name" required class="form-control" placeholder="Product Name">
    </div>
    <div class="col-6">
      <input type="text" name="code" required class="form-control" placeholder="Product Code">
    </div>
  </div>
  <div class="row" style="margin:10px;">
    <div class="col-6">
    <select class="form-control form-control-lg" required name="productcategory">
      <option value="">Select product Category</option>
      @foreach($categories as $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
      </select>
      <!-- <input type="numeric" name="stock" class="form-control" placeholder="Product Stock"> -->
    </div>
    <div class="col-6">
      <select class="form-control form-control-lg" required name="brandname">
      <option>Select product Brand</option>
      @foreach($brands as $brand)
        <option value="{{$brand->id}}">{{$brand->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <!-- <div class="col-6">
      
    </div>
  </div> -->

  <!-- <div class="row" style="margin:10px;">
    <div class="col-6">
      <input type="numeric" name="price" class="form-control" placeholder="Selling Price">
    </div>
    <div class="col-6">
      <input type="text" name="efriscategorycode" class="form-control" placeholder="Efris category code">
    </div>
  </div>

  <div class="row" style="margin:10px;">
  <div class="col-6">
      <input type="text"  name="efriscategoryname" class="form-control" placeholder="Efris category name">
    </div>
    <div class="col-6">
      <input type="text" required name="unit" class="form-control" placeholder="Product unit">
    </div>
</div> -->

<div class="row" style="margin:10px;">
    <!-- <div class="col-6">
      <input type="numeric" name="stock" class="form-control" placeholder="Product Stock">
    </div> -->
    <div class="col-4">
      <select class="form-control form-control-lg" required name="supplier">
      <option>Select product supplier</option>
      @foreach($suppliers as $supplier)
        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="col-4">
    <select class="form-control form-control-lg" style="width:200px" required name="unit">
          <option value="">Select product unit </option>
          @foreach($units as $unit)
          <option value="{{$unit->shortname}}">{{$unit->name}}</option>
        @endforeach
        </select>
    </div>

    <div class="col-4">
      <input type="text" name="categorycode" required class="form-control" placeholder="Product Efris Category Code ">
    </div>
  </div>

  <div class="row" style="margin:10px;">
  <div class="col-6">
      <input type="text" name="price" required class="form-control" placeholder="Start price. ">
    </div>
</div>
 

<!-- <div class="row" style="margin:10px;">
  <div class="col-12">
     <b>Product Unit</b>
    </div>
</div>

        <div class="row" style="margin:5px;">
        <select class="form-control col-6" style="width:200px" name="unit">
          <option selected>Select product unit </option>
          @foreach($units as $unit)
          <option value="{{$unit->shortname}}">{{$unit->name}}</option>
        @endforeach
       
        </select> -->
        <!-- <div class="col-6">
<INPUT type="checkbox"  name="chkmultiple"/><label for="dog">Is unit a multiple of.</label>
</div> -->


</div>
<!-- <INPUT type="button" class="btn btn-success" value="Add Row" onclick="addVRow('vdataTable')" /> -->

<!-- <INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteVRow('vdataTable')" />
<TABLE id="vdataTable" width="350px" style="margin:10px;">
		<TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
        <TD><INPUT type="text" style="width:150px" name="vnames[]" class="form-control producttotal" placeholder="Variance name"/></TD>
        <TD><INPUT type="text" style="width:150px" name="vquantities[]" class="form-control producttotal" placeholder="Variance Quantity"/></TD>
        <TD><INPUT type="text" style="width:150px" name="vprices[]" class="form-control producttotal" placeholder="Variance Price"/></TD>
        <TD>
        <select class="form-control" style="width:200px" name="active[]">
          <option selected>Select Active Price </option>
          <option value="1">Yes</option>
          <option value="0">No</option>
       
        </select>
        </TD>
		</TR>
	</TABLE>  -->


<!-- <div class="row" style="margin:10px;">
  <div class="col-12">
     <b>Product Locations</b>
    </div>
</div>
<INPUT type="button" class="btn btn-success" value="Add Row" onclick="addRow('dataTable')" />

<INPUT type="button" class="btn btn-danger" value="Delete Row" onclick="deleteRow('dataTable')" />
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
	</TABLE>  -->


  <!-- <div class="row">
  <input class="form-control" type="text" name="search" id="search">
  <p id="searchresults"></p>
</div> -->
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 
      </div>
    </div>
  </div>
</div>