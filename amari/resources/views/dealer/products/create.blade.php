@extends('layouts.dealer')
@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Update {{ $product->name }} for {{ \Auth::guard('dealer')->user()->dealer->tradename }}</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('store.dealer.product') }}">
            @csrf
            <div class="row mb-3">
                 <div class="col-md-6">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" id="stock" name="stock" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="sellingprice" class="form-label">Selling Price</label>
                    <input type="text" id="sellingprice" name="sellingprice" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="efris_product_code" class="form-label">Efris Product Code</label>
                    <input type="text" id="efris_product_code" name="efris_product_code" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="stock" class="form-label">Discount</label>
                    <input type="number" id="discount" name="discount" class="form-control" required>
                </div>
            </div>

            <input type="hidden" name="productid" value="{{ $product->id }}">

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
@parent
@endsection
