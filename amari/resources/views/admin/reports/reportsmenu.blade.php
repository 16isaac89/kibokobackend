@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Reports</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Example Report Cards -->
                @php
                $reports = [
                    ['name' => 'Sales Order Register', 'icon' => 'fa-list', 'color' => 'primary', 'routename' => 'admin.allreports.salesorderview'],
                    ['name' => 'Sales Register (VAN)', 'icon' => 'fa-truck', 'color' => 'info', 'routename' => 'admin.allreports.salesorderview'],
                    ['name' => 'Visit Register', 'icon' => 'fa-calendar', 'color' => 'success', 'routename' => 'admin.allreports.salesorderview'],
                    ['name' => 'Executive-wise Effort', 'icon' => 'fa-user', 'color' => 'secondary', 'routename' => 'admin.allreports.salesorderview'],
                    ['name' => 'Expense Report Details', 'icon' => 'fa-file-invoice-dollar', 'color' => 'warning', 'routename' => 'admin.allreports.salesorderview'],
                    ['name' => 'Day Cash Out Report', 'icon' => 'fa-cash-register', 'color' => 'danger', 'routename' => 'admin.allreports.salesorderview'],
                    ['name' => 'Invoice Details', 'icon' => 'fa-file-alt', 'color' => 'info', 'routename' => 'admin.allreports.salesorderview'],
                    ['name' => 'Sales Return Register', 'icon' => 'fa-undo', 'color' => 'primary', 'routename' => 'admin.allreports.salesorderview'],
                    // Add other reports here
                ];
                @endphp

                @foreach ($reports as $report)
                <div class="col-md-3 col-sm-6 mb-3">
                    <a href="{{  route($report['routename']) }}" class="text-decoration-none">
                        <div class="card text-center border-{{ $report['color'] }}">
                            <div class="card-body">
                                <div class="mb-2">
                                    <i class="fas {{ $report['icon'] }} fa-2x text-{{ $report['color'] }}"></i>
                                </div>
                                <h6 class="card-title text-dark">{{ $report['name'] }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
