@extends('layouts.dealer')

@section('content')

@include('admin.dispatch.modals.view')

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Dispatch Management</h5>
    </div>

    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('dispatches.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Dispatch
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable" id="datatable-dispatch">
                <thead class="thead-light">
                    <tr>
                        <th width="10"></th>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Count</th>
                        <th>Dispatcher</th>
                        <th>Van</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dispatches as $dispatch)
                        <tr data-entry-id="{{ $dispatch->id }}">
                            <td></td>
                            <td>{{ $dispatch->id ?? '' }}</td>
                            <td>{{ $dispatch->total ?? '' }}</td>
                            <td>{{ $dispatch->count ?? '' }}</td>
                            <td>{{ $dispatch->user->name ?? '' }}</td>
                            <td>{{ $dispatch->van->name ?? '' }}</td>
                            <td>{{ $dispatch->created_at->format('Y-m-d H:i') ?? '' }}</td>
                            <td>
                                <button data-id="{{ $dispatch->id }}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewitems">
                                    <i class="fas fa-eye"></i> View
                                </button>
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
@parent
<script>
   (function() {
    $('#datatable-dispatch').DataTable({
        dom: 'Bfrtip',
    buttons: [
        'colvis',
        'excel',
        'print',
        'copy', 'pdf','csv'
    ],
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
$('#viewitems').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
   $.ajax({
        method: "GET",
        url: "{{route('dealer.dispatch.items')}}",
        data:{"id":id,"_token": "{{ csrf_token() }}"},
         success:function(data){
            let items = data.items
            console.log(items)
             $table = $('#itemstable').DataTable({
                destroy: true,
                data: items,
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'quantity' },
                    { data: 'price' }
                ],
                "pageLength": 3,
            });


         }
        })



})
</script>
@endsection
