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
        <form method="post" action="{{ route('partner.get.dealerdispatches') }}">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <select class="custom-select" name="status">
                        <option selected disabled>Choose status...</option>
                        <option value="0" {{ isset($status) && $status == '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ isset($status) && $status == '1' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="from_date" class="form-control dispatchdate" placeholder="From Date" value="{{ $from_date ?? '' }}">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="to_date" class="form-control dispatchdate" placeholder="To Date" value="{{ $to_date ?? '' }}">
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(session('records'))
                    @foreach(session('records') as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $record->created_at->format('Y-m-d H:i') }}</td>

                        <td class="text-center">
                            <a href="{{ route('partner.dispatched.items', $record->id) }}">
                                <i class="fa fa-eye text-success fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
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
