@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <b style="color:black;font-size:25px;">Presale Orders</b>
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div class="container">
                <form id="searchForm" class="form-inline mb-3">
                    <!-- Dealers Dropdown -->
                    <div class="form-group mr-2">
                        <label for="dealer">Dealer</label>
                        <select class="form-control ml-2" id="dealer" name="dealer">
                            <option value="">Select Dealer</option>
                            <option value="0">All</option>
                            @foreach ($dealers as $dealer)
                                <option value="{{ $dealer->id }}">{{ $dealer->tradename }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Dropdown -->
                    <div class="form-group mr-2">
                        <label for="status">Status</label>
                        <select class="form-control ml-2" id="status" name="status">
                            <option value="">Select Status</option>
                            <option value="1">Pending</option>
                            <option value="2">Approved</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Search
                    </button>
                </form>

                <!-- Placeholder for the generated table -->
                <div id="tableContainer"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include DataTables and Buttons JS/CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        // Search form submit
        $('#searchForm').submit(function(event) {
            event.preventDefault();

            // Send search request via AJAX
            $.ajax({
                url: "{{ route('admin.presaleorders.search') }}", // Adjust the route name as needed
                type: 'GET',
                data: {
                    dealer: $('#dealer').val(),
                    status: $('#status').val()
                },
                success: function(response) {
                    generateAndAppendTable(response.orders);
                }
            });
        });

        // Function to generate the table and append it to the div
        function generateAndAppendTable(orders) {
            let tableHTML = `
                <table id="ordersTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Order ID</th>
                            <th>Dealer</th>
                            <th>Customer</th>
                            <th>Customer Category</th>
                            <th>Route</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${orders.map(order => `
                            <tr>
                                <td></td>
                                <td>${order.id}</td>
                                <td>${order.dealer.tradename}</td>
                                <td>${order.customer.name}</td>
                                <td>${order.customer.custcategory}</td>
                                <td>${order.customer.route.name}</td>
                                <td>${order.status === 1 || order.status === "1" ? 'Pending' : 'Approved'}</td>
                                <td>${order.created_at}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="collapse" data-target="#products-${order.id}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr id="products-${order.id}" class="collapse">
                                <td colspan="8">
                                    <table  class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${order.items.map(product => `
                                                <tr>
                                                    <td></td>
                                                    <td>${product.product.id}</td>
                                                    <td>${product.product.name}</td>
                                                    <td>${product.reqqty}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;

            // Append the generated table to the container div
            $('#tableContainer').html(tableHTML);

            // Initialize DataTable after the table is appended
            $('#ordersTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',   // Enable options for 5, 25, 50, 100 entries
                    'excelHtml5',   // Export to Excel
                    'csvHtml5',     // Export to CSV
                    'pdfHtml5',     // Export to PDF
                    'print'         // Print table
                ],
                pageLength: 5, // Set default page length
                lengthMenu: [[5, 25, 50, 100], [5, 25, 50, 100]]
            });

            // Handle row expansion for product details
            $('button[data-toggle="collapse"]').click(function() {
                let target = $(this).data('target');
                $(target).collapse('toggle');
            });
        }
    });
</script>
@endsection
