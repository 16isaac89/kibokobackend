@extends('layouts.dealer')

@section('content')
@include('dealer.dispatch.modals.count')
@include('dealer.dispatch.modals.view')
@include('dealer.dispatch.modals.refill')

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Dispatch Records</h5>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('partner.van.getdispatches') }}">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <select class="custom-select" name="van">
                        <option selected disabled>Choose Van...</option>
                        @foreach ($vans as $van)
                            <option value="{{ $van->id }}">{{ $van->name }} ({{ $van->reg_id }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="from_date" class="form-control dispatchdate" placeholder="From Date">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="to_date" class="form-control dispatchdate" placeholder="To Date">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Search</button>
                </div>
            </div>
        </form>

        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped table-hover datatable" id="datatable-dispatch">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Refill</th>
                        <th>View</th>
                        <th>Count</th>
                        <th>Add</th>
                        <th>Close Day</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $record->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-center">
                            <a data-id="{{ $record->id }}" onclick="stockrefill(this)" data-toggle="modal" data-target="#stockrefill">
                                <i class="fa fa-plus-square text-success fa-lg"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="#" onclick="viewstock(this)" data-id="{{ $record->id }}" data-records="{{ json_encode($record->dispatchproducts) }}" data-toggle="modal" data-target="#stockview">
                                <i class="fa fa-eye text-primary fa-lg"></i>
                            </a>
                        </td>
                        <td class="text-center">{{ count($record->dispatchproducts) }}</td>
                        <td class="text-center">
                            <a href="{{ route('dealer.view.topup', ['dispatch' => $record->id]) }}">
                                <i class="fa fa-clone text-warning fa-lg"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('dealer.vans.dispatched', $record->id) }}">
                                <i class="fa fa-calculator text-danger fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function() {
    $('#datatable-dispatch').DataTable({
        dom: 'Bfrtip',
        buttons: ['colvis', 'excel', 'print', 'copy', 'pdf', 'csv'],
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
    });
})();
</script>

<script>
function viewstock(d) {
    let records = JSON.parse(d.getAttribute("data-records"));
    $('#tableviewstock').DataTable().clear().destroy();
    $('#tableviewstock').DataTable({
        data: records,
        columns: [
            { data: "name" },
            { data: "dispatchedquantity" },
            { data: "sold" },
            { data: "count" },
            { data: "price" }
        ]
    });
}
</script>

<script>
function stockrefill(d) {
    let id = d.getAttribute("data-id");
    $.ajax({
        url: '{{ route('dealer.dispatch.refill') }}',
        type: 'POST',
        data: {"_token": "{{ csrf_token() }}", id: id},
        success: function(response) {
            let array = response.products;
            $('#datarefill').empty();
            array.forEach(item => {
                $('#datarefill').append(`
                    <tr>
                        <td class="font-weight-bold">${item.name}</td>
                        <td><input type="hidden" name="product[]" value="${item.id}" class="form-control"></td>
                        <td><input type="text" name="quantity[]" class="form-control" required></td>
                    </tr>`);
            });
        }
    });
}
</script>

<script>
$('.dispatchdate').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
    }
});
</script>
@endsection
