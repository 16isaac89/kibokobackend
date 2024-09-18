@extends('layouts.admin')
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
        <b style="color:black;font-size:25px;">Detailed Stock Movement Van</b>
              
            
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
    <form method="post" class="row" action="{{route('admin.stock.vanmovementsearch')}}">
                    @csrf
                    <div class="col-3">
                    <select class="form-control" name="van">
                        <option selected readonly>Select Van</option>
                        @foreach($vans as $van)
                        <option value="{{$van->id}}">{{$van->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                    <input type="text" name="fromdate" class="form-control date" placeholder="From Date" >
                    </div>
                    <div class="col-3">
                    <input type="text" name="todate" class="form-control date" placeholder="To Date" >
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-success" id="search-btn">Search</button>
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
                           Product
                        </th>
                        <th>
                            Date(stock)
                        </th>
                        <th>
                           Total in van
                        </th>
                        <th>
                          Returns 
                        </th>
                        <th>
                           Sales
                        </th>
                        <th>
                           Closing Stock
                        </th>
                        <th>
                           Count
                        </th>
                        <th>
                         Variance  
                        </th>
                        <th>
                           Remarks
                        </th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($reports as $report)
                  <tr>
                  <td></td>
                    <td>{{$report->name}}</td>
                    <td>
                      <ul>
                      @foreach($report->dispatchproducts as $dproducts)
                      <li>{{$dproducts->created_at}} ({{$dproducts->dispatchedquantity}})</li>
                      @endforeach
                    </ul>
                    </td>
                    <td>
                      {{$report->dispatchproducts->sum('dispatchedquantity')}}
                    </td>
                    <td>{{$report->returns->sum('qty_returned')}}</td>
                    <td>{{$report->sales->sum('quantity')}}</td>
                    <td>{{$report->dispatchproducts->sum('dispatchedquantity')-$report->dispatchproducts->sum('sold')}}</td>
                    <td>{{$report->dispatchcounts->sum('count')}}</td>
                    <td>{{$report->dispatchcounts->sum('dispatched')-$report->dispatchcounts->sum('count')}}</td>
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