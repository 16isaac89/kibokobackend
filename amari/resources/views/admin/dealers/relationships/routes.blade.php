<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatable datatable-Customer">
        <thead>
            <tr>
                <th width="10"></th>
                <th>Route</th>
                <th>Customers</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dealer->routes as $key => $route)
                <tr data-entry-id="{{ $route->id }}">
                    <td></td>
                    <td>{{ $route->name ?? '' }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $route->customers->count() }} Customers<br>
                        <h6>Visited:{{ $route->customers->whereNotNull('updated_at')->count(); }}</h6>


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
