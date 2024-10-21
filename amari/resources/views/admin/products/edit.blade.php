@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
       Edit Product
    </div>

    <div class="card-body">
        <form method="post" action="{{route('admin.product.edit')}}">
            @csrf
            <!-- Product Information Section -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="productname">Product Name:</label>
                    <input type="text" id="productname" name="productname" value="{{$product->name}}" class="form-control" required placeholder="Enter product name">
                </div>
                <div class="col-md-6">
                    <label for="productcode">Product Code :</label>
                    <input type="text" id="productcode" name="productcode" value="{{$product->code}}" class="form-control"
                    required placeholder="Enter product code">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="productname">Division:</label>
                    <input type="text" id="productname" name="division" value="{{$product->division}}" class="form-control"
                    required placeholder="Enter product division">
                </div>
                <div class="col-md-6">
                    <label for="productcode">Group:</label>
                    <input type="text" id="productcode" name="group" value="{{$product->group}}" class="form-control" required
                    placeholder="Enter product group">
                </div>
            </div>
            <div class="col-md-6">
                <label for="productcode">Product Category:</label>
                <select class="form-control" name="product_category" id="productunit" required>
                    <option disabled>Select product category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->code}}" {{ $product->product_category === $category->code ? 'selected' : '' }}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Product Brand and Unit Section -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="productbrandname">Product Brand:</label>
                    <select class="form-control" name="brand_id" id="productunit" required>
                        <option disabled>Select product brand</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->code}}" {{ $product->brand_id === $brand->code ? 'selected' : '' }}>{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="productunit">Product Tax:</label>
                    <select class="form-control" name="tax_id" id="productunit" required>
                        <option disabled>Select product tax</option>
                        @foreach($taxes as $tax)
                            <option value="{{$tax->id}}" {{ $product->tax_id === $tax->id ? 'selected' : '' }}>{{$tax->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Product Category Section -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="categorycode">Unit:</label>
                    <input type="text" name="unit" value="{{$product->unit}}" class="form-control" required placeholder="Enter item unit">
                </div>
            </div>

            <!-- Hidden Product ID -->
            <input type="hidden" name="productid" value="{{$product->id}}" id="productid">

            <!-- Submit Button -->
            <div class="row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    // Functionality for adding and deleting rows dynamically
    function addRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
        var colCount = table.rows[0].cells.length;

        for (var i = 0; i < colCount; i++) {
            var newcell = row.insertCell(i);
            newcell.innerHTML = table.rows[0].cells[i].innerHTML;

            switch (newcell.childNodes[0].type) {
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
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;

        for (var i = 0; i < rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if (null != chkbox && true == chkbox.checked) {
                if (rowCount <= 1) {
                    alert("Cannot delete all the rows.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    }
</script>
@endsection
