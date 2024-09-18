@extends('layouts.admin')
@section('content')

@can('suppliers_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{route('admin.productunits.viewadd')}}">
               ADD
            </a>
        </div>
    </div>
@endcan
<div class="card">
<div class="card-header">
        <b style="color:black;font-size:25px;">Product Units</b>
</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Short Name
                        </th>
             
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($units as $unit) 
                   <tr>
                    <td></td>
                    <td>{{$unit->name}}</td>
                    <td>{{$unit->shortname}}</td>
                    <td>
					<a class="btn btn-success" href="{{route('admin.units.edit',['unit'=>$unit->id])}}">Edit</a>
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('role_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
<script>
    function getsuppinfo(){
        let tin = document.getElementById('tin').value;
        $.ajax({
                url: '{{ route('admin.suppliers.checktin') }}',
                    type: 'POST',
                    data: {
                    "_token": "{{ csrf_token() }}",
                    tin:tin,
                     },
                    success: function (response) {
                       
                        console.log(response)
          

                        },

                    error: function (jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown,jqXHR);
                    }
                })
    }
    </script>
@endsection