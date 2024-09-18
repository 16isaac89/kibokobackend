@extends('layouts.admin')
@section('content')
@can('performance_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
        
            <!-- <a class="btn btn-success" href="{{ route('admin.performances.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.performance.title_singular') }}
            </a> -->
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
    <form method="post" >
            @csrf
  <div class="row">
    <div class="col">
      <input type="text" class="form-control date" placeholder="From Date">
    </div>
    <div class="col">
      <input type="text" class="form-control date" placeholder="To Date">
    </div>
    <div class="col">
      <button class="btn btn-success" type="submit">Search</button>
    </div>
  </div>
</form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Performance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.performance.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.performance.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.performance.fields.points') }}
                        </th>
                        <th>
                            {{ trans('cruds.performance.fields.type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($performances as $key => $performance)
                        <tr data-entry-id="{{ $performance->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $performance->id ?? '' }}
                            </td>
                            <td>
                                {{ $performance->user ?? '' }}
                            </td>
                            <td>
                                {{ $performance->points ?? '' }}
                            </td>
                            <td>
                                {{ $performance->type ?? '' }}
                            </td>
                            <!-- <td>
                                @can('performance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.performances.show', $performance->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('performance_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.performances.edit', $performance->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('performance_delete')
                                    <form action="{{ route('admin.performances.destroy', $performance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td> -->

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
@can('performance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.performances.massDestroy') }}",
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
  let table = $('.datatable-Performance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection