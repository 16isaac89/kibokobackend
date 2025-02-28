@extends('layouts.dealer')

@section('content')

    @include('dealer.pos.modals.addcustomer')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Order</h5>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8">
                    <button type="button" class="btn btn-success" onclick="addRow('dataTable')">Add Row</button>
                    <button type="button" class="btn btn-danger" onclick="deleteRow('dataTable')">Delete Row</button>
                </div>
                <div class="col-md-4 text-end">
                    <strong>Total:</strong> <input type="number" readonly class="form-control d-inline w-auto" id="totalcart" value="0" />
                </div>
            </div>

            <form method="post" action="{{ route('dealer.possave') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-8">
                        <select class="form-control select2" id="customer" name="customer" data-placeholder="Select Customer"></select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-success w-100" data-toggle="modal" data-target="#addcustomer">Add Customer</button>
                    </div>
                </div>

                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Brand</th>
                            <th>Product</th>

                            <th>Units</th>
                            <th>Price</th>
                            <th>Total</th>

                        </tr>
                    </thead>
                </table>

                <table id="dataTable" class="table table-bordered text-center">

                    <tbody>
                        <tr>
                            <td><input type="checkbox" name="chk"/></td>
                            <td>
                                <select name="brands[]" class="form-control brand" required>
                                    <option>Select product brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->code }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><select name="products[]" class="form-control product" required></select></td>
                            <td><input type="number" name="unit[]" class="form-control productunit" required/></td>
                            <td><input type="number" name="price[]" class="form-control productprice" readonly/></td>
                            <td><input type="number" name="total[]" class="form-control producttotal" readonly/></td>
                        </tr>
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Save</button>
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
            let colCount = table.rows[0].cells.length;
            for (let i = 0; i < colCount; i++) {
                let newCell = row.insertCell(i);
                newCell.innerHTML = table.rows[0].cells[i].innerHTML;
                switch (newCell.childNodes[0].type) {
                    case "text":
                        newCell.childNodes[0].value = "";
                        break;
                    case "checkbox":
                        newCell.childNodes[0].checked = false;
                        break;
                    case "select-one":
                        newCell.childNodes[0].selectedIndex = 0;
                        break;
                }
            }
        }

        function deleteRow(tableID) {
            let table = document.getElementById(tableID);
            let rowCount = table.rows.length;
            for (let i = 0; i < rowCount; i++) {
                let row = table.rows[i];
                let chkbox = row.cells[0].childNodes[0];
                if (chkbox && chkbox.checked) {
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

        $('#dataTable').on('change', '.brand', function() {
            let selectedValue = $(this).val();
            let row = $(this).closest('tr');
            let productSelect = row.find('.product');
            $.ajax({
                method: 'GET',
                url: "{{ route('dealer.brand.products') }}",
                data: { brand: selectedValue, "_token": "{{ csrf_token() }}" },
                success: function(response) {
                    productSelect.empty().append('<option>Select Product</option>');
                    $.each(response.products, function(index, product) {
                        productSelect.append(`<option value="${product.id}">${product.name}</option>`);
                    });
                }
            });
        });

        $('#dataTable').on('change', '.product', function() {
            let selectedValue = $(this).val();
            let row = $(this).closest('tr');
            let batchSelect = row.find('.batch');
            $.ajax({
                method: 'GET',
                url: "{{ route('dealer.product.batch') }}",
                data: { product: selectedValue, "_token": "{{ csrf_token() }}" },
                success: function(response) {
                    batchSelect.empty().append('<option>Select Product Batch</option>');
                    $.each(response.batches, function(index, batch) {
                        batchSelect.append(`<option value="${batch.id}">${batch.amount} ${batch.sellingprice}
                            ${batch.expirydate}</option>`);
                    });
                }
            });
        });
    </script>
@endsection
