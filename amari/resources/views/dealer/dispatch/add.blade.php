@extends('layouts.dealer')

@section('content')
<div class="card">
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card-body">
        <div class="d-flex mb-3">
            <button class="btn btn-success me-2" onclick="addRow('dataTable')">Add Row</button>
            <button class="btn btn-danger" onclick="deleteRow('dataTable')">Delete Row</button>
        </div>

        <form method="POST" action="{{ route('dealer.topup.store') }}">
            @csrf
            <input type="hidden" name="dispatch" value="{{ $dispatch->id }}">
            <input type="hidden" name="vanid" value="{{ $dispatch->van->id }}">

            <div class="mb-3">
                <label class="form-label h5">{{ $dispatch->van->name }}</label>
            </div>

            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Brand</th>
                        <th>Product</th>
                        <th>Batch</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dispatch->dispatchproducts as $item)
                        <tr>
                            <td>{{ $item->brandname }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                Stock: {{ $item->batchstock->amount ?? 'N/A' }}<br>
                                Price: {{ $item->batchstock->sellingprice ?? 'N/A' }}
                            </td>
                            <td>{{ $item->dispatchedquantity }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->price * $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table id="dataTable" class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Brand</th>
                        <th>Product</th>
                        <th>Batch</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" name="chk[]" class="form-check-input"></td>
                        <td>
                            <select name="brands[]" class="form-select brand">
                                <option>Select product brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><select name="products[]" class="form-select product"></select></td>
                        <td><select name="batches[]" class="form-select batch"></select></td>
                        <td><input type="text" name="unit[]" class="form-control productunit"></td>
                        <td><input type="text" name="price[]" class="form-control productprice" readonly></td>
                        <td><input type="text" name="total[]" class="form-control producttotal" readonly></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    function addRow(tableID) {
        let table = document.getElementById(tableID);
        let row = table.insertRow();
        let cells = table.rows[0].cells.length;

        for (let i = 0; i < cells; i++) {
            let newCell = row.insertCell(i);
            newCell.innerHTML = table.rows[1].cells[i].innerHTML;
            let input = newCell.querySelector("input, select");
            if (input) input.value = '';
        }
    }

    function deleteRow(tableID) {
        let table = document.getElementById(tableID);
        let rowCount = table.rows.length;

        for (let i = rowCount - 1; i > 0; i--) {
            let row = table.rows[i];
            let chkbox = row.cells[0].querySelector("input[type='checkbox']");
            if (chkbox && chkbox.checked) {
                table.deleteRow(i);
            }
        }
    }

    $(document).on('change', '.brand', function() {
        let brandId = $(this).val();
        let row = $(this).closest('tr');
        let productSelect = row.find('.product');

        $.get("{{ route('dealer.brand.products') }}", { brand: brandId }, function(response) {
            productSelect.empty().append('<option>Select Product</option>');
            response.products.forEach(product => {
                productSelect.append(`<option value="${product.id}">${product.name}</option>`);
            });
        });
    });

    $(document).on('change', '.product', function() {
        let productId = $(this).val();
        let row = $(this).closest('tr');
        let batchSelect = row.find('.batch');

        $.get("{{ route('dealer.product.batch') }}", { product: productId }, function(response) {
            batchSelect.empty().append('<option>Select Batch</option>');
            response.batches.forEach(batch => {
                batchSelect.append(`<option value="${batch.id}">${batch.amount} - ${batch.sellingprice} - ${batch.expirydate}</option>`);
            });
        });
    });

    $(document).on('change', '.batch', function() {
        let batchId = $(this).val();
        let row = $(this).closest('tr');
        let unitInput = row.find('.productunit');
        let priceInput = row.find('.productprice');
        let totalInput = row.find('.producttotal');

        $.get("{{ route('dealer.batch.price') }}", { batch: batchId }, function(response) {
            let data = response.batch;
            unitInput.val(1);
            priceInput.val(data.sellingprice);
            totalInput.val(data.sellingprice);
        });
    });

    $(document).on('input', '.productunit', function() {
        let row = $(this).closest('tr');
        let unit = parseInt($(this).val()) || 0;
        let price = parseFloat(row.find('.productprice').val()) || 0;
        row.find('.producttotal').val(unit * price);
    });
</script>
@endsection
