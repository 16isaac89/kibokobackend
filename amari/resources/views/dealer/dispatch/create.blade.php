@extends('layouts.dealer')

@section('content')
    @include('admin.dealers.modals.add')
    @include('admin.dealers.modals.edit')

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Add New Dispatch</h4>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Error:</strong> {{ $errors->first() }}
            </div>
        @endif

        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-success" onclick="addRow('dataTable')">Add Row</button>
                <button class="btn btn-danger" onclick="deleteRow('dataTable')">Delete Row</button>
            </div>

            <form method="post" action="{{ route('dispatches.store') }}">
                @csrf
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="inlineFormCustomSelect">Van</label>
                        <select class="custom-select" name="van" required>
                            <option readonly value="">Choose van.</option>
                            @foreach ($vans as $van)
                                <option value="{{ $van->id }}">{{ $van->name }} {{ $van->reg_id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="dispatchdate">Dispatch Date</label>
                        <input type="text" class="form-control dispatchdate" placeholder="Dispatch date" required name="dispatchdate"/>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 50px;">Select</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Stock (Total/Exp)</th>
                                <th class="text-center">Units</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" name="chk" /></td>
                                <td>
                                    <select name="brands[]" class="form-control brand" required>
                                        <option>Select product brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->code }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="products[]" id="productlist" required class="form-control product"></select>
                                </td>
                                <td>
                                    <input type="number" readonly name="batches[]" id="batchlist" required class="form-control batch" />
                                </td>
                                <td><input type="number" required name="unit[]" id="productunit" class="form-control productunit" /></td>
                                <td><input type="text" readonly name="price[]" class="form-control productprice" /></td>
                                <td><input type="text" readonly name="total[]" class="form-control producttotal" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save</button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script language="javascript">
        function addRow(tableID) {
    var table = document.getElementById(tableID);
    var tbody = table.querySelector('tbody'); // Get the tbody element
    var rowCount = tbody.rows.length; // Get current row count
    var row = tbody.insertRow(rowCount); // Insert new row in tbody

    var colCount = table.rows[0].cells.length; // Get the number of columns

    for (var i = 0; i < colCount; i++) {
        var newcell = row.insertCell(i); // Insert a new cell in the new row
        newcell.innerHTML = table.rows[1].cells[i].innerHTML; // Copy content from the first row

        switch (newcell.childNodes[0].type) {
            case "text":
                newcell.childNodes[0].value = ""; // Clear input fields
                break;
            case "checkbox":
                newcell.childNodes[0].checked = false; // Uncheck checkbox
                break;
            case "select-one":
                newcell.childNodes[0].selectedIndex = 0; // Reset select boxes
                break;
        }
    }
}
        function deleteRow(tableID) {
            try {
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
            } catch (e) {
                alert(e);
            }
        }
    </script>

    <script>

        $('#dataTable').on('change', '.brand', function() {
            var selectedValue = $(this).val();
            var row = $(this).closest('tr'); // get the row
            var stateSelect = row.find('.product'); // get the other select in the same row
            $.ajax({
                method: 'GET',
                url: "{{ route('dealer.brand.products') }}",
                data: { brand: selectedValue, "_token": "{{ csrf_token() }}" },
                success: function(response) {
                    let data = response.products;
                    stateSelect.empty();
                    stateSelect.append($('<option></option>').text("Select Product"));
                    $.each(data, function(item, index) {
                        stateSelect.append($('<option></option>')
                                .val(index.id)
                                .text(index.name)
                                .attr('data-stock', index.dealerproduct.stock ?? 0)
                                .attr('data-sellingprice', index.dealerproduct.sellingprice ?? 0));
                       // stateSelect.append($('<option></option>').val(index.id).text(index.name));
                    });
    //                 stateSelect.select2({
    //     placeholder: "Select an option", // Placeholder text
    //     allowClear: true // Allow clearing the selection
    // });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#dataTable').on('change', '.product', function() {
            var selectedValue = $(this).val();
            var row = $(this).closest('tr'); // get the row
            var availStock = row.find('.batch'); // get the other select in the same row
            var availPrice = row.find('.productprice');
            var availUnit = row.find('.productunit');
            var availTotal = row.find('.producttotal');
             // Get the selected option element
    var selectedOption = $(this).find('option:selected');
    var stockValue = selectedOption.data('stock'); // Retrieve the data-stock attribute
    var sellingpriceValue = selectedOption.data('sellingprice'); // Retrieve the data-sellingprice attribute
    availPrice.val(sellingpriceValue);
    availStock.val(stockValue);
    let total = parseInt(sellingpriceValue) * 1;
    availTotal.val(total);
    availUnit.val(1);
    console.log("Selected Stock:", stockValue); // Use the stock value as needed

            // $.ajax({
            //     method: 'GET',
            //     url: "{{ route('dealer.product.batch') }}",
            //     data: { product: selectedValue, "_token": "{{ csrf_token() }}" },
            //     success: function(response) {
            //         let data = response.batches;
            //         stateSelect.empty();
            //         stateSelect.append($('<option></option>').text("Select Product Batch"));
            //         $.each(data, function(item, index) {
            //             stateSelect.append($('<option></option>').val(index.id).text(index.amount + ' ' + index.expirydate));
            //         });
            //     },
            //     error: function(error) {
            //         console.log(error);
            //     }
            // });
        });

        $('#dataTable').on('change', '.batch', function() {
            var selectedValue = $(this).val();
            var row = $(this).closest('tr'); // get the row
            var productunit = row.find('.productunit');
            var productprice = row.find('.productprice');
            var producttotal = row.find('.producttotal');

            $.ajax({
                method: 'GET',
                url: "{{ route('dealer.batch.price') }}",
                data: { batch: selectedValue, "_token": "{{ csrf_token() }}" },
                success: function(response) {
                    let data = response.batch;
                    row.find('#productunit').attr('max', data.amount);
                    productunit.val("1");
                    productprice.val("");
                    producttotal.val("");
                    productprice.val(data.sellingprice);
                    producttotal.val(parseInt("1") * parseInt(data.sellingprice));
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#dataTable').on('change click keyup input paste', '.productunit', function() {
            var selectedValue = $(this).val();
            var row = $(this).closest('tr');
            var productprice = row.find('.productprice');
            var producttotal = row.find('.producttotal');
            let total = parseInt(selectedValue) * parseInt(productprice.val());
            producttotal.val(total);
        });

        $('.dispatchdate').datetimepicker({
            minDate: new Date(),
            format: 'YYYY-MM-DD',
            locale: 'en',
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        });
    </script>
@endsection
