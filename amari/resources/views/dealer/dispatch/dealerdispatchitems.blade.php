@extends('layouts.dealer')

@section('content')


<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Dispatch Records</h5>
    </div>
    <div class="card-body">

<form method="post" action="{{ route('dealer.update.dispatched') }}">
    @csrf
    <input name="dispatchid" type="hidden" value="{{ $dispatch->id }}">
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped table-hover datatable" id="datatable-dispatch">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Dispatched</th>
                        <th>Received</th>
                    </tr>
                </thead>
                <tbody>
                    @if($dispatch->dispatchproducts)
                    @foreach( $dispatch->dispatchproducts as $index => $dispatchproduct)
                    <tr>
                        <td>{{ $index + 1 }} <input type="hidden" name="dispatchproductids[]" value="{{ $dispatchproduct->id }}" />
                        </td>
                        <td>{{ $dispatchproduct->product->brand->name }}</td>
                        <td>{{ $dispatchproduct->product->brand->name }}</td>
                        <td>{{ $dispatchproduct->quantity }}</td>
                        <td>
                            @if($dispatch->status == 0)
                            <input type="number" name="receiveds[]" class="form-control" />
                            @else
                            {{ $dispatchproduct->received }}
                            @endif
                        </td>

                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>
        @if($dispatch->status == 0)
        <button type="submit" class="btn btn-primary">Submit {{ \Auth::guard('dealer')->user()->dealer->efris == 1 ? 'And Sync with Efris' : '' }}</button>
        @endif
</form>
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
