@extends('layouts.dealer')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-bold">
       Edit Products
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('bulk-edit-products.dealer.products') }}">
            @csrf
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light fw-bold">
                            <span><b>Product:{{ $product->name }}</b></span><br>
                            <span><b>Brand  :{{ $product->brand->name }}</b></span><br>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">
                                <strong>{{ $product->dealerproduct ? 'Editing Existing Item' : 'Adding New Item' }}</strong>
                            </p>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="stock_{{ $product->id }}" class="form-label">Stock</label>
                                    <input type="number" required id="stock_{{ $product->id }}" name="stocks[]" value="{{ $product->dealerproduct ? $product->dealerproduct->stock : '' }}" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="sellingprice_{{ $product->id }}" class="form-label">Selling Price</label>
                                    <input type="number" required id="sellingprice_{{ $product->id }}" name="sellingprices[]" value="{{ $product->dealerproduct ? $product->dealerproduct->sellingprice : '' }}" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="efris_code_{{ $product->id }}" class="form-label">Efris Product Code</label>
                                    <input type="text" id="efris_code_{{ $product->id }}" name="efris_product_codes[]" class="form-control"
                                     value="{{ $product->dealerproduct?->efris_product_code ? $product->dealerproduct?->efris_product_code : $product->code }}"
                                    >
                                </div>
                                <div class="col-6">
                                    <label for="discount_{{ $product->id }}" class="form-label">Discount</label>
                                    <input type="number" id="discount_{{ $product->id }}" name="discounts[]" class="form-control" required
                                    value="{{ $product->dealerproduct?->discount ? $product->dealerproduct?->discount : '' }}"
                                    >
                                </div>
                            </div>
                            <input type="hidden" name="productids[]" value="{{ $product->id }}">
                            <input type="hidden" name="status[]" value="{{ $product->dealerproduct ? '1' : '0' }}">
                            <input type="hidden" name="dealerproductids[]" value="{{ $product->dealerproduct ? $product->dealerproduct?->id : '' }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary mt-3 px-4">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
@endsection
