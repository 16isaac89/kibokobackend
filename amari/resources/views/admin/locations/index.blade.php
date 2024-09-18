@extends('layouts.admin')
@section('content')
@include('admin.locations.modals.add')
@include('admin.locations.modals.edit')
@can('permission_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" data-toggle="modal" data-target="#addlocation">
               Add
            </a>
        </div>
    </div>
@endcan
<div class="card">
<div class="card-header">
        <b style="color:black;font-size:25px;">Product Locations</b>
</div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Permission">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                           action
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locations as $location)
                        <tr data-entry-id="{{ $location->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $location->name ?? '' }}
                            </td>
                            <td>
                                <a data-id="{{$location->id}}" data-name="{{$location->name}}" class="btn btn-primary" data-toggle="modal" data-target="#editlocation">edit</a>
                            </td>
                            <td></td>

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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Permission:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
<script>
    $('#editlocation').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var name = button.data('name')
  document.getElementById('locationid').value = id
  document.getElementById('locationname').value = name
})
    </script>
@endsection