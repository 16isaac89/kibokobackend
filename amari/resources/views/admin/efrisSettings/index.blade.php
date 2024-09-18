@extends('layouts.admin')
@section('content')
@can('efris_setting_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.efris-settings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.efrisSetting.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EfrisSetting', 'route' => 'admin.efris-settings.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.efrisSetting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EfrisSetting">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.aeskey') }}
                        </th>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.tin') }}
                        </th>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.deviceno') }}
                        </th>
                        <th>
                            {{ trans('cruds.efrisSetting.fields.keypath') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($efrisSettings as $key => $efrisSetting)
                        <tr data-entry-id="{{ $efrisSetting->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $efrisSetting->id ?? '' }}
                            </td>
                            <td>
                                {{ $efrisSetting->aeskey ?? '' }}
                            </td>
                            <td>
                                {{ $efrisSetting->tin ?? '' }}
                            </td>
                            <td>
                                {{ $efrisSetting->deviceno ?? '' }}
                            </td>
                            <td>
                                {{ $efrisSetting->keypath ?? '' }}
                            </td>
                            <td>
                                @can('efris_setting_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.efris-settings.show', $efrisSetting->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('efris_setting_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.efris-settings.edit', $efrisSetting->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('efris_setting_delete')
                                    <form action="{{ route('admin.efris-settings.destroy', $efrisSetting->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('efris_setting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.efris-settings.massDestroy') }}",
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
  let table = $('.datatable-EfrisSetting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection