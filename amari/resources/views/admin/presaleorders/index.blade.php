@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Preorder Details
        </div>
        <div class="card-body">

            <!-- Search Form with From Date and To Date -->
            <form method="GET" action="{{ route('admin.presaleorders.searchbydatepost') }}">
                <div class="row m-5">
                    <div class="col-md-3">
                        <label for="from_date">From Date</label>
                        <input type="text" name="from_date" class="form-control date" id="from_date">
                    </div>
                    <div class="col-md-3">
                        <label for="to_date">To Date</label>
                        <input type="text" name="to_date" class="form-control date" id="to_date">
                    </div>
                    <div class="col-md-2 mt-4">
                        <!-- Search Button with Loader -->
                        <button type="button" id="search-btn" onclick="getDetails()" class="btn btn-primary mt-2">
                            <span id="search-text">Search</span>
                            <span id="search-loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                    <div class="col-md-4 text-right mt-4">
                        <!-- Export Buttons -->
                        <a href="#" class="btn btn-info export-btn" data-type="csv">Export CSV</a>
                        <a href="#" class="btn btn-success export-btn" data-type="excel">Export Excel</a>
                        {{-- <a href="#" class="btn btn-danger export-btn" data-type="pdf">Export PDF</a> --}}
                    </div>
                </div>
            </form>

            <!-- DataTable -->
            <div id="datatable-container"></div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        function getDetails() {
            let fromDate = document.getElementById('from_date').value;
            let toDate = document.getElementById('to_date').value;

            if (fromDate == '' || toDate == '' || fromDate == null || toDate == null || fromDate == undefined || toDate == undefined) {
                alert('Please select a date range');
                return;
            } else {
                // Show loader and disable button
                document.getElementById('search-text').style.display = 'none';
                document.getElementById('search-loader').style.display = 'inline-block';
                document.getElementById('search-btn').disabled = true;

                $.ajax({
                    url: '{{ route('admin.presaleorders.searchbydatepost') }}',
                    type: 'GET',
                    data: {
                        'fromdate': fromDate,
                        'todate': toDate,
                        '__token': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        let preorders = data.preorders;
                        generateDataTable(preorders);

                        // Hide loader and enable button
                        document.getElementById('search-text').style.display = 'inline';
                        document.getElementById('search-loader').style.display = 'none';
                        document.getElementById('search-btn').disabled = false;
                    },
                    error: function(error) {
                        console.log(error);

                        // Hide loader and enable button in case of error
                        document.getElementById('search-text').style.display = 'inline';
                        document.getElementById('search-loader').style.display = 'none';
                        document.getElementById('search-btn').disabled = false;
                    }
                });
            }
        }

        function generateDataTable(preorders) {
            const table = document.createElement('table');
            table.id = 'bootstrap-datatable';
            table.classList.add('table', 'table-bordered', 'table-striped', 'table-hover', 'datatable');

            // Generate the table header
            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th>Invoice No</th>
                    <th>Invoice Date</th>
                      <th>Sales Person</th>
                    <th>Customer Name</th>
                    <th>SUBD</th>
                    <th>Executive Name</th>
                    <th>Product Code</th>
                    <th>Quantity</th>
                    <th>Item Description</th>
                    <th>Basic Value</th>
                    <th>VAT Value</th>
                    <th>Total Sales</th>
                    <th>Route</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                </tr>
            `;
            table.appendChild(thead);

            // Generate the table body
            const tbody = document.createElement('tbody');
            preorders.forEach(preorder => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${preorder.stockreqs.id ?? ''}</td>
                   <td>${new Date(preorder.stockreqs.created_at).toLocaleString('en-GB', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
})}</td>
<td>${preorder.stockreqs.saler?.username ?? ''}</td>
                    <td>${preorder.stockreqs.customer.name ?? ''}</td>
                    <td>${preorder.stockreqs.dealer.tradename ?? ''}</td>
                    <td>${preorder.stockreqs.saler.username}</td>
                    <td>${preorder.product.code}</td>
                    <td>${preorder.reqqty}</td>
                    <td>${preorder.product.description ?? ''}</td>
                    <td>${preorder.sellingprice}</td>
                    <td>${preorder.product.tax_amount ?? 0}</td>
                    <td>${preorder.total}</td>
                    <td>${preorder.stockreqs.customerroute.name}</td>
                    <td>${preorder.stockreqs.checkin}</td>
                    <td>${preorder.stockreqs.checkout}</td>
                `;
                tbody.appendChild(row);
            });
            table.appendChild(tbody);

            // Clear and append the table
            document.getElementById('datatable-container').innerHTML = '';
            document.getElementById('datatable-container').appendChild(table);

            // Initialize DataTables
            $('#bootstrap-datatable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true
            });
        }
    </script>
    <script>
        document.querySelectorAll('.export-btn').forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        let fromDate = document.getElementById('from_date').value;
        let toDate = document.getElementById('to_date').value;
        let type = this.getAttribute('data-type');

        if (fromDate == '' || toDate == '' || fromDate == null || toDate == null) {
            alert('Please select a date range');
            return;
        }

        // Redirect to the correct export route with query parameters
        window.location.href = `/admin/presaleorders/export/?from_date=${fromDate}&to_date=${toDate}&type=${type}`;
    });
});
    </script>
@endsection
