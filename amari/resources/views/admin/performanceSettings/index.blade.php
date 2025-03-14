@extends('layouts.admin')
@section('content')
@can('performance_setting_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.performance-settings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.performanceSetting.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'PerformanceSetting', 'route' => 'admin.performance-settings.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.performanceSetting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-PerformanceSetting">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.fromdate') }}
                        </th>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.todate') }}
                        </th>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.points') }}
                        </th>
                        <th>
                            {{ trans('cruds.performanceSetting.fields.pointtype') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($performanceSettings as $key => $performanceSetting)
                        <tr data-entry-id="{{ $performanceSetting->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $performanceSetting->id ?? '' }}
                            </td>
                            <td>
                                {{ $performanceSetting->fromdate ?? '' }}
                            </td>
                            <td>
                                {{ $performanceSetting->todate ?? '' }}
                            </td>
                            <td>
                                {{ $performanceSetting->points ?? '' }}
                            </td>
                            <td>
                                {{ $performanceSetting->pointtype ?? '' }}
                            </td>
                            <td>
                                @can('performance_setting_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.performance-settings.show', $performanceSetting->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('performance_setting_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.performance-settings.edit', $performanceSetting->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('performance_setting_delete')
                                    <form action="{{ route('admin.performance-settings.destroy', $performanceSetting->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('performance_setting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.performance-settings.massDestroy') }}",
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
  let table = $('.datatable-PerformanceSetting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection