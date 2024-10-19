@extends('layouts.dealer')
@section('content')

<div class="card">
    <div class="card-header">
       Edit Products
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('bulk-edit-products.dealer.products') }}">
            @csrf
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-6"> <!-- Adjust the column width as needed -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <b>{{ $product->name }}</b>
                        </div>
                        <div class="card-body">
                            <p><b>{{ $product->dealerproduct ? 'Editing Existing Item' : 'Adding New Item' }}</b></p>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="stock">Stock:</label>
                                    <input type="number" required id="stock" name="stocks[]" value="{{ $product->dealerproduct ? $product->dealerproduct->stock : '' }}" class="form-control" >
                                </div>
                                <div class="col-6">
                                    <label for="sellingprice">Selling Price:</label>
                                    <input required type="number" id="sellingprice" name="sellingprices[]" value="{{ $product->dealerproduct ? $product->dealerproduct->sellingprice : '' }}" class="form-control" >
                                </div>
                            </div>
                            <input type="hidden" name="productids[]" value="{{ $product->id }}" id="productid">
                            <input type="hidden" name="status[]" value="{{ $product->dealerproduct ? '1' : '0' }}">
                            <input type="hidden" name="dealerproductids[]" value="{{ $product->dealerproduct ? $product->dealerproduct->id : '' }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
@parent
@endsection
