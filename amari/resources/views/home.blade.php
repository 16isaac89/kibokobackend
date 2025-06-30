@extends('layouts.admin')

@section('styles')
<style>
    /* Brand Color Variables */
    :root {
        --kiboko-blue: #2c5cc5;
        --kiboko-light-blue: #4e73df;
        --kiboko-green: #1cc88a;
        --kiboko-dark: #2d3748;
        --kiboko-light: #f8f9fc;
    }

    body {
        background-color: var(--kiboko-light);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.5rem 0 rgba(45, 55, 72, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem 0 rgba(45, 55, 72, 0.15);
    }

    .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
        font-weight: 700;
        color: var(--kiboko-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }

    /* Stats Cards */
    .stats-card {
        padding: 1.5rem;
        position: relative;
        color: white;
        border-left: 4px solid rgba(255, 255, 255, 0.3);
    }

    .card-bg-primary {
        background-color: var(--kiboko-blue);
        background: linear-gradient(135deg, var(--kiboko-blue) 0%, var(--kiboko-light-blue) 100%);
    }

    .card-bg-success {
        background-color: var(--kiboko-green);
        background: linear-gradient(135deg, var(--kiboko-green) 0%, #28d494 100%);
    }

    .card-bg-info {
        background: linear-gradient(135deg, #36b9cc 0%, #2cc5dc 100%);
    }

    .card-bg-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #f8d56b 100%);
    }

    .stats-card h6 {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .stats-card h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0;
    }

    .stats-card i {
        position: absolute;
        right: 1.5rem;
        bottom: 1.5rem;
        opacity: 0.2;
        font-size: 3.5rem;
    }

    /* Table Styles */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: var(--kiboko-dark);
    }

    .table th {
        background-color: #f8fafc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: var(--kiboko-blue);
        padding: 1rem;
        border-top: none;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem;
        border-top: 1px solid #f1f5f9;
    }

    .table tr:hover td {
        background-color: #f8fafc;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 300px;
        padding: 1rem;
    }

    /* Button Styles */
    .btn-kiboko {
        background-color: var(--kiboko-blue);
        color: white;
        border: none;
        border-radius: 0.375rem;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-kiboko:hover {
        background-color: #1d4ed8;
        color: white;
        transform: translateY(-1px);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stats-card h3 {
            font-size: 1.5rem;
        }

        .stats-card i {
            font-size: 2.5rem;
        }

        .card-header {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid mt-4">
        @if(auth()->user()->designation == 1 || auth()->user()->designation == "1")
        <!-- Dashboard Stats Row -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.customers.index') }}" class="card stats-card card-bg-primary h-100">
                    <div class="card-body">
                        <h6>Customers</h6>
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ $customers }}</h3>
                                <span class="text-white-50 small">Geotagged: {{ $geotagged }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card card-bg-success h-100">
                    <div class="card-body">
                        <h6>Routes</h6>
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ $routes }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-route"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card card-bg-info h-100">
                    <div class="card-body">
                        <h6>Dealers</h6>
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ $dealers }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-store"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card card-bg-warning h-100">
                    <div class="card-body">
                        <h6>Vans</h6>
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ $vans }}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-truck"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">Presale By Month</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="presalesmonthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Recent Presale Orders</h6>
                <a href="#" class="btn btn-sm btn-kiboko">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="recentSalesTable">
                        <thead>
                            <tr>
                                <th width="40"><input type="checkbox"></th>
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
                                <td>{{ $preorder->created_at->format('M d, Y') }}</td>
                                <td>#{{ $preorder->stockreqs->id }}</td>
                                <td>{{ $preorder->stockreqs->customer->name }}</td>
                                <td>{{ number_format($preorder->reqqty) }}</td>
                                <td>KSh {{ number_format($preorder->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade spinnermodal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Presales Chart
    const monthlyData = @json(array_values($preordersmonth));
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const ctx = document.getElementById('presalesmonthChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Monthly Presales',
                data: monthlyData,
                backgroundColor: 'rgba(44, 92, 197, 0.7)',
                borderColor: 'rgba(44, 92, 197, 1)',
                borderWidth: 1,
                borderRadius: 4,
                hoverBackgroundColor: 'rgba(28, 200, 138, 0.8)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        stepSize: Math.max(...monthlyData) > 10 ? Math.ceil(Math.max(...monthlyData)/5) : 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(45, 55, 72, 0.9)',
                    titleFont: {
                        weight: 'bold'
                    },
                    padding: 12,
                    cornerRadius: 4
                }
            }
        }
    });
</script>
@endsection
