@extends('layouts.admin')
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <!-- <a class="btn btn-success" href="{{ route('admin.roles.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
            </a> -->
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
          <thead>
            <tr>
            <th class="wd-15p"></th>
              <th class="wd-15p">ID</th>
              <th class="wd-15p">Date</th>
              <th class="wd-15p">Sales Rep</th>
              <th class="wd-20p">Customer</th>
              <th class="wd-20p">Route</th>
              <th class="wd-20p">Amount</th>
              <th class="wd-20p">Debit/Credit Note</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sales as $sale)
            <tr>
              <td></td>
            <td>{{$sale->saleidentification}}</td>
              <td>{{$sale->created_at}}</td>
              <td>{{$sale->user->username ?? ''}}</td>
              <td>{{$sale->customer->name ?? ''}}</td>
              <td>{{$sale->route->name ?? ''}}</td>
              <td>{{$sale->total ?? ''}}</td>
              <td>
<a class="btn btn-warning" href="{{route('admin.sales.creditview',['sale'=>$sale->id])}}">
  Credit Note
</a>
<a class="btn btn-primary" href="{{route('admin.sales.debitview',['sale'=>$sale->id])}}">
  Debit Note
</a>
<a class="btn btn-success" href="{{route('admin.note.status')}}">
Status
</a>

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