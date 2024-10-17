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
                    <input type="text" name="from_date" class="form-control date" id="from_date" >
                </div>
                <div class="col-md-3">
                    <label for="to_date">To Date</label>
                    <input type="text" name="to_date" class="form-control date" id="to_date">
                </div>
                <div class="col-md-2 mt-4">
                    <button type="submit" class="btn btn-primary mt-2">Search</button>
                </div>
                <div class="col-md-4 text-right mt-4">
                    <!-- Export Buttons -->
                    <a href="#" class="btn btn-info export-btn" data-type="csv">Export CSV</a>
                    <a href="#" class="btn btn-success export-btn" data-type="excel">Export Excel</a>
                    <a href="#" class="btn btn-danger export-btn" data-type="pdf">Export PDF</a>
                </div>
            </div>
        </form>

        <!-- DataTable -->
        <table class="table table-bordered table-striped table-hover datatable">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Invoice Date</th>
                    <th>Customer Name</th>
                    <th>Executive Name</th>
                    <th>Product Code</th>
                    <th>Item Description</th>
                    <th>Basic Value</th>
                    <th>VAT Value</th>
                    <th>Total Sales</th>
                    <th>Route</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($preorders as $preorder)
                    <tr>
                        <td>{{ $preorder->invoice_no }}</td>
                        <td>{{ $preorder->invoice_date }}</td>
                        <td>{{ $preorder->customer_name }}</td>
                        <td>{{ $preorder->executive_name }}</td>
                        <td>{{ $preorder->product_code }}</td>
                        <td>{{ $preorder->item_description }}</td>
                        <td>{{ $preorder->basic_value }}</td>
                        <td>{{ $preorder->vat_value }}</td>
                        <td>{{ $preorder->total_sales }}</td>
                        <td>{{ $preorder->route }}</td>
                        <td>{{ $preorder->in_time }}</td>
                        <td>{{ $preorder->out_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    document.querySelectorAll('.export-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            let fromDate = document.getElementById('from_date').value;
            let toDate = document.getElementById('to_date').value;
            let type = this.getAttribute('data-type');
            let url = `{{ route('admin.presaleorders.export', '') }}/${type}?from_date=${fromDate}&to_date=${toDate}`;

            window.location.href = url;
        });
    });
</script>
@endsection()
