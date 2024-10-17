@extends('layouts.admin')
@section('styles')
<style>
    .card {
        border-radius: 0;
    }
    .table th, .table td {
        padding: 0.5rem;
    }
    .calendar-cell {
        width: 40px;
        height: 40px;
        text-align: center;
        padding: 5px;
    }
    .calendar-cell.active {
        background-color: #007bff;
        color: white;
        border-radius: 50%;
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif




                    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
                        <!-- Navbar -->
                        <div class="container-fluid mt-4">
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Customers</h6>
                                            <h3 class="card-text">{{ $customers }}</h3>
                                            <i class="fas fa-chart-line text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Routes</h6>
                                            <h3 class="card-text">{{ $routes }}</h3>
                                            <i class="fas fa-chart-bar text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Dealers</h6>
                                            <h3 class="card-text">{{ $dealers }}</h3>
                                            <i class="fas fa-chart-area text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Vans</h6>
                                            <h3 class="card-text">{{ $vans }}</h3>
                                            <i class="fas fa-chart-pie text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Worldwide Sales</h5>
                                            <a href="#" class="float-right">Show All</a>
                                            <canvas id="worldwideSalesChart" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Sales & Revenue</h5>
                                            <a href="#" class="float-right">Show All</a>
                                            <canvas id="salesRevenueChart" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Recent Sales</h5>
                                    <a href="#" class="float-right">Show All</a>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox"></th>
                                                <th>Date</th>
                                                <th>Invoice</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox"></td>
                                                <td>01 Jan 2045</td>
                                                <td>INV-0123</td>
                                                <td>Jhon Doe</td>
                                                <td>$123</td>
                                                <td>Paid</td>
                                                <td><button class="btn btn-sm btn-primary">Detail</button></td>
                                            </tr>
                                            <!-- Repeat the above row structure for more entries -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Messages</h5>
                                            <a href="#" class="float-right">Show All</a>
                                            <ul class="list-unstyled">
                                                <li class="media mb-3">
                                                    <img src="https://via.placeholder.com/50" class="mr-3 rounded-circle" alt="User">
                                                    <div class="media-body">
                                                        <h6 class="mt-0 mb-1">Jhon Doe</h6>
                                                        <p class="mb-0">Short message goes here...</p>
                                                        <small class="text-muted">15 minutes ago</small>
                                                    </div>
                                                </li>
                                                <!-- Repeat the above list item for more messages -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Calendar</h5>
                                            <a href="#" class="float-right">Show All</a>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7" class="text-center">
                                                            <button class="btn btn-link"><i class="fas fa-chevron-left"></i></button>
                                                            October 2024
                                                            <button class="btn btn-link"><i class="fas fa-chevron-right"></i></button>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Su</th>
                                                        <th>Mo</th>
                                                        <th>Tu</th>
                                                        <th>We</th>
                                                        <th>Th</th>
                                                        <th>Fr</th>
                                                        <th>Sa</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Calendar rows go here -->
                                                    <tr>
                                                        <td class="calendar-cell">29</td>
                                                        <td class="calendar-cell">30</td>
                                                        <td class="calendar-cell">1</td>
                                                        <td class="calendar-cell">2</td>
                                                        <td class="calendar-cell">3</td>
                                                        <td class="calendar-cell">4</td>
                                                        <td class="calendar-cell">5</td>
                                                    </tr>
                                                    <!-- More rows... -->
                                                    <tr>
                                                        <td class="calendar-cell">13</td>
                                                        <td class="calendar-cell active">14</td>
                                                        <td class="calendar-cell">15</td>
                                                        <td class="calendar-cell">16</td>
                                                        <td class="calendar-cell">17</td>
                                                        <td class="calendar-cell">18</td>
                                                        <td class="calendar-cell">19</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">To Do List</h5>
                                            <a href="#" class="float-right">Show All</a>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Enter task">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button">Add</button>
                                                </div>
                                            </div>
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <input type="checkbox" class="mr-2">
                                                        Short task goes here...
                                                    </div>
                                                    <button class="btn btn-sm btn-link"><i class="fas fa-times"></i></button>
                                                </li>
                                                <!-- Repeat the above list item for more tasks -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </main>







                    </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg spinnermodal"  data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection
