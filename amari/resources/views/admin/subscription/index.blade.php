@extends('layouts.admin')
@section('content')
@can('subscription_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.subscriptions.create') }}">
               Create
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.subscription.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-subscription">
                <thead>

                    <tr>
                        <th width="10">

                        </th>
                        <th>
                        subscription
                        </th>
                        <th>
                          Type
                        </th>
                        <th>
                            Description
                          </th>
                          <th>
                            Grace period
                          </th>
                          <th>
                            Days
                          </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $key => $subscription)
                        <tr data-entry-id="{{ $subscription->id }}">
                            <td>
                            </td>
                            <td>
                                {{ $subscription->name ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->type ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->description ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->grace_period ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->days ?? '' }}
                            </td>
                            <td>
                                @can('subscription_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.subscriptions.show', $subscription->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('subscription_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.subscriptions.edit', $subscription->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('subscription_delete')
                                    <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-subscription:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
