@extends('layouts.admin')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Edit Product</h5>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('admin.product.edit') }}">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="productname" class="form-label">Product Name:</label>
                    <input type="text" id="productname" name="productname" value="{{ $product->name }}" class="form-control" required placeholder="Enter product name">
                </div>
                <div class="col-md-6">
                    <label for="productcode" class="form-label">Product Code:</label>
                    <input type="text" id="productcode" name="productcode" value="{{ $product->code }}" class="form-control" required placeholder="Enter product code">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="division" class="form-label">Division:</label>
                    <select class="form-control" name="division" id="division" required>
                        <option disabled selected>Select a division</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ $product->division == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="group" class="form-label">Group:</label>
                    <input type="text" id="group" name="group" value="{{ $product->group }}" class="form-control" required placeholder="Enter product group">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="product_category" class="form-label">Product Category:</label>
                    <select class="form-control" name="product_category" id="product_category" required>
                        <option disabled selected>Select product category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->code }}" {{ $product->product_category == $category->code ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="brand_id" class="form-label">Product Brand:</label>
                    <select class="form-control" name="brand_id" id="brand_id" required>
                        <option disabled selected>Select product brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->code }}" {{ $product->brand_id == $brand->code ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tax_id" class="form-label">Product Tax:</label>
                    <select class="form-control" name="tax_id" id="tax_id" required>
                        <option disabled selected>Select product tax</option>
                        @foreach($taxes as $tax)
                            <option value="{{ $tax->id }}" {{ $product->tax_id == $tax->id ? 'selected' : '' }}>{{ $tax->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="unit" class="form-label">Unit:</label>
                    <input type="text" id="unit" name="unit" value="{{ $product->unit }}" class="form-control" required placeholder="Enter unit">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="unit" class="form-label">Tax Amount:</label>
                    <input type="text" id="unit" name="unit" value="{{ $product->tax_amount }}" class="form-control"
                    required placeholder="eg 0,18">
                </div>
                <div class="col-md-6">
                    <label for="unit" class="form-label">Selling Price:</label>
                    <input type="text" id="price" value="{{ $product->selling_price }}" name="price" class="form-control"
                    required placeholder="eg 0,18">
                </div>
            </div>

            <input type="hidden" name="productid" value="{{ $product->id }}">

            <div class="text-end">
                <button type="submit" class="btn btn-success">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
