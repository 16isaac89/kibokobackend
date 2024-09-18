@extends('layouts.admin')
@section('content')
@include('admin.dispatch.modals.view')

@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{route('admin.dispatch.create')}}">
                ADD DISPATCH
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
       Dispatch List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-dispatch">
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
                           Dealer
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
                                {{ $dispatch->dealer->tradename ?? '' }}
                            </td>
                            <td>
                                {{ $dispatch->created_at ?? '' }}
                            </td>
                            
                            <td>
                                {{-- <button type="button" class="btn btn-primary">Primary</button>
<button type="button" class="btn btn-secondary">Secondary</button> --}}
                                @can('dispatch_copy')
                                    <a href="{{route('admin.dispatch.copy',['id'=>$dispatch->id])}}"  class="btn btn-xs btn-info">
                                        Copy
                                    </a>
                                @endcan
                                @can('dispatch_copy')
                                <button data-id="{{$dispatch->id}}"  class="btn btn-xs btn-success" data-toggle="modal" data-target="#viewitems">
                                   View
                                </button>
                            @endcan
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
 
$(document).ready(function () {
    var table = $('.datatable-dispatch').DataTable({
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
           
            { data: '' },
            { data: 'ID' },
            { data: 'Total' },
            { data: 'Count' },
            { data: 'Dispatcher' },
            { data: 'Dealer' },
            { data: 'Date' },
            
        ],
        order: [[1, 'asc']],
    });
 
   
});

</script>
<script>
$('#viewitems').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
   $.ajax({
        method: "GET",
        url: "{{route('admin.dispatch.items')}}",
        data:{"id":id,"_token": "{{ csrf_token() }}"},
         success:function(data){
            let items = data.items
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