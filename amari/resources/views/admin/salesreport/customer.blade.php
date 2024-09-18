@extends('layouts.admin')
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
         
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
   
        <b style="color:black;font-size:25px;">Customer Performance Report</b>

    <form class="row g-3" method="post" action="{{route('admin.search.pfm')}}">
          @csrf
  <div class="col-md-3">
  <label for="inputState" class="form-label">Van</label>
    <select  class="form-control" name="vanid" id="vanid">
      <option selected>Choose van</option>
      @foreach ($vans as $van)
			  <option value="{{$van->id}}">{{$van->name}} {{$van->reg_id}}</option>
			  @endforeach
    </select>
</div>
<div class="col-3">
    <label for="inputAddress2" class="form-label">From date</label>
    <input type="text" class="form-control date" name="fromdate">
  </div>
  <div class="col-3">
    <label for="inputAddress2" class="form-label">To date</label>
    <input type="text" class="form-control date"  name="todate" >
  </div>
<div class="col-3">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Item
                        </th>
                        <th>
                            Contact
                        </th>
                        <th>
                            Route
                        </th>
                        <th>
                            TIN
                        </th>
                        <th>
                            EFRIS STATUS
                        </th>
                        <th>
                           Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                    <td></td>
                        <td>{{$report->client->identification ?? ''}}</td>
                        <td>{{$report->client->name ?? ''}}</td>
                        <td>{{$report->name ?? ''}}</td>
                        <td>{{$report->client->phone ?? ''}}</td>
                        <td>{{$report->client->route->name ?? ''}}</td>
                        <td>{{$report->client->tin ?? ''}}</td>
                        <td>
                        @if($report->client->efrisstatus)
                        @if($report->client->efrisstatus === 1)
                        <span class="badge badge-pill badge-success">Registered</span>
                        @elseif($report->client->efrisstatus === 0)
                        <span class="badge badge-pill badge-warning">Unregistered</span>
                        @endif
                        @endif
                        </td>
                        <td>{{$report->total ?? ''}}</td>
                        
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
@endsection