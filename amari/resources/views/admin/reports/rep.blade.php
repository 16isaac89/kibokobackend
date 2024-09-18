@extends('layouts.admin')
@section('content')
@can('permission_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" >
            Sales Report
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
    <form method="post" action="{{route('admin.searchrep.report')}}">
        @csrf
  <div class="form-row">
    <div class="col-4">
      <input type="text" class="form-control month" name="month" placeholder="Month">
    </div>
    <div class="col-4">
      <input type="text" class="form-control year" name="year" placeholder="Year">
    </div>
    <div class="col-4">
      <button class="btn btn-success" type="submit">SEARCH</button>
    </div>
  </div>
</form>
    </div>

    <div class="card-body">
        <div class="table-responsive" style="overflow:auto;">
        <table id="sales"  class="table table-bordered table-striped table-hover datatable datatable-sales" style="table-layout:fixed">
          <thead>
            <tr>
                <th width="10"></th>
            <th class="wd-15p">Rep</th>
              <th class="wd-20p">Planned Sales</th>
              <th class="wd-20p">Actual Sales</th>
              <th class="wd-20p">Planned Cov</th>
              <th class="wd-20p">Actual Cov</th>
             
            </tr>
          </thead>
          <tbody>
          @foreach($sales as $sale)
            <tr data-entry-id="{{ $sale->id }}">
                <td></td>
              <td>{{$sale->username}}</td>
              <td>{{$sale->target->money ?? 0}}</td>
              <td>{{$sale->sales->sum('total')}}</td>
              <td>{{count($sale->plans)}}</td>
              <td>{{count($sale->sales)}}</td>
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
<!-- <script>
  function format(d) {
    // `d` is the original data object for the row
    return (
        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Full name:</td>' +
        '<td>' +
        d.name +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Extension number:</td>' +
        '<td>' +
        d.extn +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Extra info:</td>' +
        '<td>And any further details here (images etc)...</td>' +
        '</tr>' +
        '</table>'
    );
}
  (function() {
    var table = $('#sales').DataTable({
        ajax: '{{route('dealer.indexreports')}}',
        dom: 'Bfrtip',
    buttons: [
        'colvis',
        'excel',
        'print',
        'copy', 'pdf','csv'
    ],
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
            { data: 'id' },
            { data: 'created_at' },
            { data: 'wqwq' },
            { data: 'position' },
            { data: 'office' },
           
        ],
        order: [[1, 'asc']],
    });
 
    // Add event listener for opening and closing details
    $('#sales tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
})();
      </script> -->

      <script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-sales:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  table.columns.adjust().draw();
  
})

</script>
      <script>
        $('.year').datetimepicker({
    format: 'YYYY',
    locale: 'en',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.month').datetimepicker({
    format: 'MM',
    locale: 'en',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })
</script>
@endsection