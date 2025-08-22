@extends('layouts.admin')
@section('content')
@include('admin.customers.modals.latlong')
    @can('customer_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-6">
                <a class="btn btn-success" href="{{ route('admin.customers.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadLatLong">
                    Update geotag
                </button>
                @include('csvImport.modal', [
                    'model' => 'Customer',
                    'route' => 'admin.customers.parseCsvImport',
                ])
            </div>
            <div class="col-lg-6">
                <a href="{{ route('admin.customers.export.excel') }}" class="btn btn-primary">Export Excel</a>
                <a href="{{ route('admin.customers.export.csv') }}" class="btn btn-secondary">Export CSV</a>
            </div>
             <div class="col-lg-6">
                <a href="{{ route('admin.customers.exporttagged.excel') }}" class="btn btn-primary">Export Geotagged Excel</a>
                <a href="{{ route('admin.customers.exporttagged.csv') }}" class="btn btn-secondary">Export Geotagged CSV</a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.customer.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Customer">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>Dealer</th>
                            <th>Route</th>
                            <th>Customer</th>

                            <th>CheckIN</th>
                            <th>Checkout</th>
                            <th>Telephone No</th>
                            <th>{{ trans('cruds.customer.fields.phone') }}</th>
                            <th>{{ trans('cruds.customer.fields.email') }}</th>
                            <th>Area</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Classifications</th>
                            <th>Cash Registers</th>
                            <th>Daily Footfall</th>
                            <th>Product Range</th>
                            <th>Contact Person</th>
                            <th>Customer Category</th>
                            <th>B'ss Value</th>
                            <th>Location</th>
                            <th>Lat</th>
                            <th>Long</th>
                            <th>IMGlat</th>
                            <th>IMGlong</th>
                            <th>Image</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $customer)
                            <tr data-entry-id="{{ $customer->id }}">
                                <td></td>
                                <td>{{ $customer->dealer->tradename ?? '' }}</td>
                                <td>{{ $customer->route->name ?? '' }}</td>
                                <td>{{ $customer->name ?? '' }}</td>


                                <td>{{ $customer->customercheckin ?? '' }}</td>
                                <td>{{ $customer->customercheckout ?? '' }}</td>

                                <td>{{ $customer->telephoneno ?? '' }}</td>
                                <td>{{ $customer->phone ?? '' }}</td>
                                <td>{{ $customer->email ?? '' }}</td>
                                <td>{{ $customer->area ?? '' }}</td>
                                <td>{{ $customer->city ?? '' }}</td>
                                <td>{{ $customer->country ?? '' }}</td>
                                <td>{{ $customer->classification ?? '' }}</td>
                                <td>{{ $customer->cashregisters ?? '' }}</td>
                                <td>{{ $customer->dailyfootfall ?? '' }}</td>
                                <td>{{ $customer->productrange ?? '' }}</td>
                                <td>{{ $customer->contact_person ?? '' }}</td>
                                <td>{{ $customer->custcategory ?? '' }}</td>
                                <td>{{ $customer->businessvalue ?? '' }}</td>
                                <td>{{ $customer->location ?? '' }}</td>

                                <td>{{ $customer->latitude }}</td>
                                <td>{{ $customer->longitude }}</td>
                                <td>{{ $customer->subdimagelat }}</td>
                                <td>{{ $customer->subdimagelong }}</td>
                                <td>
                                    @if ($customer->location_image)
                                        @php
                                            $url = $customer->location_image->getUrl();
                                            $needle = 'uploads/';
                                            $insert = '/amari/public';

                                            // Find the position of 'uploads' in the URL
                                            $pos = strpos($url, $needle);

                                            // If 'uploads' is found, insert 'amari/public' before it
                                            if ($pos !== false) {
                                                $url = substr_replace($url, $insert . '/', $pos, 0);
                                            }
                                        @endphp
                                        <img src="{{ $url }}" alt="Location Image" style="width: 100px; height: auto;">
                                    @endif
                                </td>

                                <td>
                                    @can('customer_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.customers.show', $customer->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('customer_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.customers.edit', $customer->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('customer_delete')
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('customer_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.customers.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Customer:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
