@extends('layouts.admin')
@section('styles')
<style>
    /* General Styles */
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
        --success-color: #1cc88a;
        --info-color: #36b9cc;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
    }

    body {
        background-color: #f8f9fc;
    }

    /* Card Styles */
    .card {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-3px);
    }

    .card-header {
        border-bottom: 1px solid #e3e6f0;
        padding: 1.25rem;
        font-weight: 900;
        color: var(--primary-color);
    }

    /* Stats Cards with Color Backgrounds */
    .card-bg-primary { background-color: var(--primary-color); color: white; }
    .card-bg-success { background-color: var(--success-color); color: white; }
    .card-bg-info { background-color: var(--info-color); color: white; }
    .card-bg-warning { background-color: var(--warning-color); color: white; }

    /* Adjust text and icon colors in stats cards */
    .stats-card h6, .stats-card h3, .stats-card i { color: rgb(15, 15, 15); }

    .stats-card {
        padding: 1.5rem;
        position: relative;
    }

    .stats-card i {
        position: absolute;
        right: 1rem;
        bottom: 1rem;
        opacity: 0.4;
        font-size: 2.5rem;
    }

    /* Table Styles */
    .table th {
        background-color: #f8f9fc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        color: var(--secondary-color);
    }

    .table td {
        vertical-align: middle;
        padding: 1rem;
    }

    /* Spinner Modal */
    .spinnermodal .modal-content {
        background: transparent;
        border: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card {
            margin-bottom: 1rem;
        }

        .stats-card h3 {
            font-size: 1.6rem;
        }
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid mt-4">
        <!-- Dashboard Header Row -->
        <div class="row mb-4">
            <div class="col-md-3">
                <a href="{{ route('admin.customers.index') }}" class="card stats-card card-bg-primary">
                    <h6 class="card-header">Customers</h6>
                    <div class="card-body">
                        <h3 class="card-text">All:{{ $customers }}</h3>
                        <h3 class="card-text">Geotagged: {{ $geotagged }}</h3>
                        <i class="fas fa-users"></i>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <div class="card stats-card card-bg-success">
                    <h6 class="card-header">Routes</h6>
                    <div class="card-body">
                        <h3 class="card-text">{{ $routes }}</h3>
                        <i class="fas fa-route"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card card-bg-info">
                    <h6 class="card-header">Dealers</h6>
                    <div class="card-body">
                        <h3 class="card-text">{{ $dealers }}</h3>
                        <i class="fas fa-store"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card card-bg-warning">
                    <h6 class="card-header">Vans</h6>
                    <div class="card-body">
                        <h3 class="card-text">{{ $vans }}</h3>
                        <i class="fas fa-truck"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales and Revenue Charts Row -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Presale By Month</h5>

                        <canvas id="presalesmonthChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sales & Revenue</h5>
                        <a href="#" class="float-right">Show All</a>
                        <canvas id="salesRevenueChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Recent Sales Table -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Recent Presale Orders</h5>
                <a href="#" class="float-right">Show All</a>
                <table class="table table-striped" id="recentSalesTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Dealer</th>
                            <th>Date</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Quantity</th>
                            <th>Amount</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preorders as $preorder)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>{{ $preorder->stockreqs->dealer->tradename }}</td>
                            <td>{{ $preorder->created_at }}</td>
                            <td>{{ $preorder->stockreqs->id }}</td>
                            <td>{{ $preorder->stockreqs->customer->name }}</td>
                            <td>{{ $preorder->reqqty }}</td>
                            <td>{{ $preorder->total }}</td>
                        </tr>
                        @endforeach

                        <!-- Repeat rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Other Components (Messages, Calendar, To-Do List) -->
        {{-- <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Messages</h5>
                        <ul class="list-unstyled">
                            <li class="media mb-3">
                                <img src="https://via.placeholder.com/50" class="mr-3 rounded-circle" alt="User">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">John Doe</h6>
                                    <p>Short message here...</p>
                                    <small class="text-muted">15 minutes ago</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Calendar</h5>
                        <!-- Calendar Structure -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">To Do List</h5>
                        <!-- To Do List Structure -->
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<div class="modal fade spinnermodal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x" style="color: var(--primary-color);"></span>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get monthly data from the backend
    const monthlyUpdatesCount = @json(array_values($preordersmonth)); // [0, 0, 0, ..., 11, 0, 0]

    // Labels for each month
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    // Render the chart
    const ctx = document.getElementById('presalesmonthChart').getContext('2d');
    const monthlyUpdatesChart = new Chart(ctx, {
        type: 'bar', // or 'line' for a line chart
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Monthly Updates Count',
                data: monthlyUpdatesCount,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number Orders'
                    }
                }
            }
        }
    });
</script>
@endsection
