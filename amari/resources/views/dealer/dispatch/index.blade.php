@extends('layouts.dealer')
@section('content')
@include('admin.dispatch.modals.view')
<div class="card">

<div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
        <a class="btn btn-success" href="{{route('dispatches.create')}}" class="button btn-primary">
                ADD DISPATCH
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-dispatch" id="datatable-dispatch">
                <thead>
                    <tr>
                        <th width="10">

                        </th>

                        <th>
                            ID
                        </th>
                        <th>
                            Total
                        </th>
                        <th>
                           Count
                        </th>
                        <th>
                            Dispatcher
                        </th>
                        <th>
                           Van
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($dispatches as $dispatch)
                        <tr data-entry-id="{{ $dispatch->id }}">

                            <td>

                            </td>
                            <td>
                                {{ $dispatch->id ?? '' }}
                            </td>

                            <td>
                                {{ $dispatch->total ?? '' }}
                            </td>
                             <td>
                                {{ $dispatch->count ?? '' }}
                            </td>
                             <td>
                                {{ $dispatch->user->name ?? '' }}
                            </td>
                             <td>
                                {{ $dispatch->van->name ?? '' }}
                            </td>
                            <td>
                                {{ $dispatch->created_at ?? '' }}
                            </td>

                            <td>
                                {{-- <button type="button" class="btn btn-primary">Primary</button>
<button type="button" class="btn btn-secondary">Secondary</button> --}}
                                <!-- @can('dispatch_copy')
                                    <a href="{{route('admin.dispatch.copy',['id'=>$dispatch->id])}}"  class="btn btn-xs btn-info">
                                        Copy
                                    </a>
                                @endcan -->

                                <button data-id="{{$dispatch->id}}"  class="btn btn-xs btn-success" data-toggle="modal" data-target="#viewitems">
                                   View
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
