@extends('layouts.admin')
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.summaryday.addview') }}">
                ADD
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
   
        <b style="color:black;font-size:25px;">Summary Day Book</b>

    <form class="row g-3" method="post" action="{{route('admin.summary.search')}}">
          @csrf
  <div class="col-4">
    <label for="inputAddress2" class="form-label">From date</label>
    <input type="text" class="form-control date" name="fromdate">
  </div>
  <div class="col-4">
    <label for="inputAddress2" class="form-label">To date</label>
    <input type="text" class="form-control date"  name="todate" >
  </div>


  <div class="col-4">
  <button id="search-button" type="submit" class="btn btn-primary">
    <i class="fa fa-search"></i>
  	</button>
  </div>
</form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            DAY
                        </th>
                        <th>
                            VAN/SHOP
                        </th>
                        <th>
                            Cash Expected
                        </th>
                        <th>
                            Cash Received
                        </th>
                        <th>
                            Variance
                        </th>
                        <th>
                            Comment
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                    <td></td>
                    <td>{{ $result->created_at ?? '' }}</td>
                    <td>{{ $result->van->name ?? '' }}</td>
                    <td>{{ $result->expected ?? '' }}</td>
                    <td>{{ $result->received ?? '' }}</td>
                    <td>{{ $result->difference ?? '' }}</td>
                    <td>{{ $result->comment ?? '' }}</td>
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