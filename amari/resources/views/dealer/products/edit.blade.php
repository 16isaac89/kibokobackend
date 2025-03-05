@extends('layouts.dealer')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Product</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('update.dealer.product', $item->id) }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" id="stock" name="stock" value="{{ $item->stock }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="sellingprice" class="form-label">Selling Price</label>
                    <input type="number" id="sellingprice" name="sellingprice" value="{{ $item->sellingprice }}" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="efris_product_code" class="form-label">Efris Product Code</label>
                    <input type="text" id="efris_product_code"
                    value="{{ $item->efris_product_code ? $item->efris_product_code : $product->code }}"
                    name="efris_product_code" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="discount" class="form-label">Discount</label>
                    <input type="number" id="discount" name="discount" value="{{ $item->discount }}" class="form-control" required>
                </div>
            </div>

            <input type="hidden" name="productid" value="{{ $product->id }}">

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@if($item && $item->discounts->isNotEmpty())
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">Discount History</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="discountTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Discount</th>
                        <th>Selling Price</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($item->discounts as $price)
                    <tr>
                        <td>{{ $price->discount }}</td>
                        <td>{{ number_format($price->item_price, 2) }}</td>
                        <td>{{ $price->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
@parent

<script>
    $(document).ready(function() {
        $('#discountTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "responsive": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "paginate": {
                    "previous": "<",
                    "next": ">"
                }
            }
        });
    });
</script>
@endsection
