<div class="container-fluid">
    <!-- Sales Updated Today Table -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Pre-Sales Today ({{ count($salesToday) }}) sales ({{ $salesToday->sum('total') }})UGX</h5>
        </div>
        <div class="card-body">
            <table id="salesTodayTable" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th></th> <!-- For expand/collapse icon -->
                        <th>Name</th>
                        <th>Route</th>
                        <th>Sales Person</th>
                        <th>Invoice ID</th>
                        <th>Checkin</th>
                        <th>Checkout</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesToday as $sale)
                    <tr>
                        <td class="details-control"></td>
                        <td>{{ $sale->requestcustomer?->name }}</td>
                        <td>{{ $sale->customerroute->name }}</td>
                        <td>{{ $sale->saler->username }}</td>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->checkin }}</td>
                        <td>{{ $sale->checkout }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customers Today Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Customers Today ({{ count($customersToday) }})</h5>
        </div>
        <div class="card-body">
            <table id="customersTodayTable" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Route</th>
                        <th>Checkin</th>
                        <th>Checkout</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customersToday as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->route->name }}</td>
                        <td>{{ $customer->checkin }}</td>
                        <td>{{ $customer->checkout }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


