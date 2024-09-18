@extends('layouts.admin')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" >
             {{ $dealer->tradename }} Subscriptions
            </a>
        </div>
    </div>
    @can('subscription_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.dealer.addsub',$dealer->id) }}">
                {{ trans('global.add') }} Dealer Subscription
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
                        <th width="10">
Subscription
                        </th>
                        <th>
                    From Date
                        </th>
                        <th>
              To Date
                        </th>
                        <th>
                        Paid On
                                      </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dealer->dealersubs as $key => $subscription)
                        <tr data-entry-id="{{ $subscription->id }}">
                            <th width="10">

                            </th>
                            <td>
                                {{ $subscription->subscription->name ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->from_date ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->to_date ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->paid_on ?? '' }}
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
