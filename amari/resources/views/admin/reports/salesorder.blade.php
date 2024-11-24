@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Search Filters -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Search</div>
                <div class="card-body">
                    <form id="searchForm">
                        <div class="form-group">
                            <label for="fromDate">From Date</label>
                            <input type="text" class="form-control date" id="fromDate" name="fromDate">
                        </div>
                        <div class="form-group">
                            <label for="toDate">To Date</label>
                            <input type="text" class="form-control date" id="toDate" name="toDate">
                        </div>
                        {{-- <div class="form-group">
                            <label for="division">Division</label>
                            <select class="form-control" id="division" name="division">
                                <option value="">--Select Division--</option>
                                <option value="PNG">PNG DIVISION</option>
                                <!-- Add other divisions dynamically if needed -->
                            </select>
                        </div> --}}
                        <button type="button" onclick="search()" class="btn btn-primary btn-block">Submit</button>
                        {{-- <button type="reset" class="btn btn-secondary btn-block">Reset</button> --}}
                    </form>
                </div>
            </div>
        </div>

        <!-- Sales Orders Table -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">Sales Orders Register</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="loader" class="text-center" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover" id="salesOrdersTable">
                            <thead>
                                <tr>
                                    <th>View</th>
                                    <th>Order No</th>
                                    <th>Order Date</th>
                                    <th>Customer</th>
                                    <th>Executive</th>

                                    <th>Product Desc</th>
                                    <th>Product Qty</th>
                                    <th>Product Rate</th>

                                    <th>Discount Per</th>
                                    <th>Vat Per</th>
                                    <th>Order Value</th>

                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function search() {
        // Initialize DataTable
        const table = $('#salesOrdersTable').DataTable();

            // Show loader
            $('#loader').show();

            // Get form data
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            // console.log(fromDate, toDate);
            // return
            // const division = $('#division').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route("admin.allreports.salesordersearch") }}', // Your route to fetch data
                method: 'GET',
                data: { fromDate, toDate},
                success: function (response) {
                    // Clear existing data
                    console.log(response);
                    $('#loader').hide();
                    table.clear();

                    // Populate table with response data
                    response.orders.forEach(order => {
                        table.row.add([
                            `<a href="/order/${order.id}" class="btn btn-sm btn-primary">View</a>`,
                            order.stockreqs.id,
                            order.stockreqs.created_at,
                            order.stockreqs.customer.name,
                            order.stockreqs.saler.username,
                            order.product?.code,

                            order.reqqty,
                            order.product?.selling_price,

                            order.discount,
                            order.vat_amount,
                            order.total,

                        ]).draw();
                    });
                },
                error: function (error) {
                    console.log(error)
                    $('#loader').hide();
                    alert('Failed to fetch data. Please try again.');
                },

            });

    }
</script>
@endsection
