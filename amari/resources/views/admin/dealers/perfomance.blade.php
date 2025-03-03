@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Dealer Performance
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.captainperfomance.index') }}">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <!-- Table Displaying the Data -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Performance">
                <thead>
                    <tr>
                        <th></th>
                        <th>Dealer</th>
                        <th>Added Customers</th>
                        <th>Updated Customers</th>
                        <th>Presale Orders</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($performances as $performance)
                    <tr>
                        <td></td>
                        <td>{{ $performance->dealer->tradename }}</td>
                        <td>{{ $performance->added_customers }}</td>
                        <td>{{ $performance->visited_customers }}</td>
                        <td>{{ $performance->presale_orders }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function() {
        // Initialize DataTable for the performance table
        $('.datatable-Performance').DataTable({
            processing: true,
            serverSide: false, // This is set to false since data is being passed from the controller
            pageLength: 10,
            order: [[0, 'asc']],
        });
    });
</script>
@endsection
