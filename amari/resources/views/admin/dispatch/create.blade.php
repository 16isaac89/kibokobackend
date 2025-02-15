@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header text-uppercase font-weight-bold">
        Add New Dispatch
    </div>

    <div class="card-body">
        <div class="mb-3">
            <button type="button" class="btn btn-success" onclick="addRow('dataTable')">Add Row</button>
            <button type="button" class="btn btn-danger" onclick="deleteRow('dataTable')">Delete Row</button>
        </div>

        <form method="POST" action="{{ route('admin.dispatch.store') }}">
            @csrf

            <div class="form-group">
                <label for="dealer">Dealer</label>
                <select class="form-control" id="dealer" name="dealer" required>
                    <option selected value="0">Choose dealer</option>
                    @foreach ($dealers as $dealer)
                        <option value="{{ $dealer->id }}">{{ $dealer->tradename }} - {{ $dealer->phonenumber }}</option>
                    @endforeach
                </select>
            </div>

            <table class="table table-bordered mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>Action</th>
                        <th>Brand</th>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    <tr>
                        <td><input type="checkbox" name="chk" /></td>
                        <td>
                            <select name="brands[]" id="brand" class="form-control brand">
                                <option>Select product brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->code }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="products[]" class="form-control product"></select>
                        </td>
                        <td><input type="number" name="unit[]" class="form-control productunit" min="1" value="1" /></td>
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
        row.innerHTML = table.rows[0].innerHTML;
        row.querySelectorAll('input, select').forEach(el => {
            if (el.type === 'text' || el.type === 'number') el.value = '';
            if (el.type === 'checkbox') el.checked = false;
            if (el.tagName === 'SELECT') el.selectedIndex = 0;
        });
    }

    function deleteRow(tableID) {
        let table = document.getElementById(tableID);
        let rowCount = table.rows.length;
        for (let i = 0; i < rowCount; i++) {
            let row = table.rows[i];
            let chkbox = row.cells[0].querySelector('input[type=checkbox]');
            if (chkbox && chkbox.checked) {
                if (rowCount <= 1) {
                    alert("Cannot delete all rows.");
                    return;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    }

    $(document).on('change', '#brand', function() {
        let row = $(this).closest('tr');
        let productSelect = row.find('.product');
        console.log($(this).val())
        $.get("{{ route('admin.brand.products') }}",
        { brand: $(this).val(), _token: "{{ csrf_token() }}" },
        function(response) {
            console.log(response)
            productSelect.empty().append('<option>Select Product</option>');
            $.each(response.products, function(index, item) {
                productSelect.append(`<option value="${item.id}">${item.name}</option>`);
            });
        });
    });

    $(document).on('change', '.product', function() {
        let row = $(this).closest('tr');
        let unit = row.find('.productunit');
        let price = row.find('.productprice');
        let total = row.find('.producttotal');
        $.get("{{ route('admin.product.details') }}", { product: $(this).val(), _token: "{{ csrf_token() }}" }, function(response) {
            unit.val(1);
            price.val(response.product.price);
            total.val(response.product.price);
        });
    });

    $(document).on('input', '.productunit', function() {
        let row = $(this).closest('tr');
        let price = parseFloat(row.find('.productprice').val()) || 0;
        let units = parseInt($(this).val()) || 1;
        row.find('.producttotal').val(price * units);
    });
</script>
@endsection
