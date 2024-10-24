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
                        <label for="from_date">Month</label>
                        <input type="text" name="mont" class="form-control month" id="month">
                    </div>
                    <div class="col-md-3">
                        <label for="to_date">Year</label>
                        <input type="text" name="year" class="form-control year" id="year">
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
            let month = document.getElementById('month').value;
            let year = document.getElementById('year').value;

            if (month == '' || year == '' || month == null || year == null || year == undefined || month == undefined) {
                alert('Please select a month and year');
                return;
            } else {
                // Show loader and disable button
                document.getElementById('search-text').style.display = 'none';
                document.getElementById('search-loader').style.display = 'inline-block';
                document.getElementById('search-btn').disabled = true;

                $.ajax({
                    url: '{{ route('admin.presaleorders.searchGeneral') }}',
                    type: 'GET',
                    data: {
                        'month': month,
                        'year': year,
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
            console.log(preorders);
            const table = document.createElement('table');
            table.id = 'bootstrap-datatable';
            table.classList.add('table', 'table-bordered', 'table-striped', 'table-hover', 'datatable');

            // Generate the table header
            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th></th>
                    <th>Company</th>
                        <th>Executive</th>
                        <th>Van Name</th>
                        <th>Checkin</th>
                        <th>Checkout</th>
                        <th>Routes</th>
                        <th>Total Outlets</th>
                        <th>Visited Outlets</th>
                        <th>New Outlets</th>
                        <th>Calls</th>
                        <th>Invoice Total</th>
                        <th>Sales Target</th>
                        <th>Target Achieved</th>
                </tr>
            `;
            table.appendChild(thead);

            // Generate the table body
            const tbody = document.createElement('tbody');
            preorders.forEach(preorder => {
                let routes = preorder.dealer.routes;
                let requests = preorder.van.stockrequests
                let requeststotal = 0;
                requests.forEach(request => {
                    requeststotal += request.total;
                })
                  // Prepare route information
        // const routeInfo = routes.map(route => {
        //     const customerCount = route.customers.length;
        //     return `${route.name} (${customerCount} Customers)`;
        // }).join(', ');
        // Join multiple routes with a comma


                const row = document.createElement('tr');
                row.innerHTML = `
                  <td></td>
                    <td>${preorder.dealer?.tradename ?? ''}</td>
                   <td>${preorder.saler?.username ?? ''}</td>
                    <td>${preorder.van?.name ?? ''}</td>
                    <td>${preorder.checkin ?? ''}</td>
                    <td>${preorder.checkout}</td>
                    <td>${preorder.customerroute.name ?? ''}</td>
                    <td>${preorder.customerroute.customers.length ?? ''}</td>
                    <td>${preorder.customerroute.updated_customers.length}</td>
                    <td>${preorder.customerroute.new_customers.length}</td>
                    <td>${preorder.items.length}</td>
                    <td>${preorder.total}</td>
                    <td>${preorder.van.target?.money ?? ''}</td>
                    <td>${requeststotal}</td>
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

        let month = document.getElementById('month').value;
            let year = document.getElementById('year').value;
            let type = this.getAttribute('data-type');

            if (month == '' || year == '' || month == null || year == null || year == undefined || month == undefined) {
                alert('Please select a month and year');
                return;
        }

        // Redirect to the correct export route with query parameters
        window.location.href = `/admin/presaleorders/exportgeneral/?month=${month}&year=${year}&type=${type}`;
    });
});
    </script>
@endsection
