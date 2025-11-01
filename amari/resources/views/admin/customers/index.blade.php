@extends('layouts.admin')

@section('content')
@include('admin.customers.modals.latlong')

@can('customer_create')
<div class="mb-4">
    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.customers.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle mr-1"></i> {{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}
                        </a>
                        {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            <i class="fas fa-file-import mr-1"></i> {{ trans('global.app_csvImport') }}
                        </button> --}}
                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadLatLong">
                            <i class="fas fa-map-marker-alt mr-1"></i> Update Geotag
                        </button> --}}
                    </div>
                    @include('csvImport.modal', [
                        'model' => 'Customer',
                        'route' => 'admin.customers.parseCsvImport',
                    ])
                </div>

                <div class="col-md-6 text-md-right mb-2">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.customers.export.excel') }}" class="btn btn-outline-success">
                            <i class="fas fa-file-excel mr-1"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.customers.export.excelinactive') }}" class="btn btn-outline-success">
                            <i class="fas fa-file-excel mr-1"></i> Export Excel Inactive
                        </a>
                        {{-- <a href="{{ route('admin.customers.export.csv') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-file-csv mr-1"></i> Export CSV
                        </a> --}}
                    </div>
                </div>
                {{-- <div class="col-md-6 text-md-right mb-2">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.customers.export.excelinactive') }}" class="btn btn-outline-success">
                            <i class="fas fa-file-excel mr-1"></i> Export Excel Inactive
                        </a>

                    </div>
                </div> --}}

                <div class="col-md-12 text-md-right mt-2">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.customers.exporttagged.excel') }}" class="btn btn-outline-primary">
                            <i class="fas fa-map-pin mr-1"></i> Export Geotagged Excel
                        </a>
                         <a href="{{ route('admin.customers.exporttaggedinactive.excel') }}" class="btn btn-outline-primary">
                            <i class="fas fa-map-pin mr-1"></i> Export Geotagged Inactive
                        </a>
                        {{-- <a href="{{ route('admin.customers.exporttagged.csv') }}" class="btn btn-outline-dark">
                            <i class="fas fa-map-pin mr-1"></i> Export Geotagged CSV
                        </a> --}}
                    </div>
                </div>
                {{-- <div class="col-md-12 text-md-right mt-2">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.customers.exporttagged.excel') }}" class="btn btn-outline-primary">
                            <i class="fas fa-map-pin mr-1"></i> Export Geotagged Inactive
                        </a>

                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endcan

<div class="card shadow-sm border-0">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-users mr-2"></i> {{ trans('cruds.customer.title_singular') }} {{ trans('global.list') }}
        </h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered datatable datatable-Customer align-middle">
                <thead class="thead-light">
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
                        <th>B’ss Value</th>
                        <th>Location</th>
                        <th>Lat</th>
                        <th>Long</th>
                        <th>IMGlat</th>
                        <th>IMGlong</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $key => $customer)
                    <tr data-entry-id="{{ $customer->id }}">
                        <td></td>
                        <td>{{ $customer->dealer->tradename ?? '-' }}</td>
                        <td>{{ $customer->route->name ?? '-' }}</td>
                        <td><strong>{{ $customer->name ?? '-' }}</strong></td>
                        <td>{{ $customer->customercheckin ?? '-' }}</td>
                        <td>{{ $customer->customercheckout ?? '-' }}</td>
                        <td>{{ $customer->telephoneno ?? '-' }}</td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td>{{ $customer->email ?? '-' }}</td>
                        <td>{{ $customer->area ?? '-' }}</td>
                        <td>{{ $customer->city ?? '-' }}</td>
                        <td>{{ $customer->country ?? '-' }}</td>
                        <td>{{ $customer->classification ?? '-' }}</td>
                        <td>{{ $customer->cashregisters ?? '-' }}</td>
                        <td>{{ $customer->dailyfootfall ?? '-' }}</td>
                        <td>{{ $customer->productrange ?? '-' }}</td>
                        <td>{{ $customer->contact_person ?? '-' }}</td>
                        <td>{{ $customer->custcategory ?? '-' }}</td>
                        <td>{{ $customer->businessvalue ?? '-' }}</td>
                        <td>{{ $customer->location ?? '-' }}</td>
                        <td>{{ $customer->latitude ?? '-' }}</td>
                        <td>{{ $customer->longitude ?? '-' }}</td>
                        <td>{{ $customer->subdimagelat ?? '-' }}</td>
                        <td>{{ $customer->subdimagelong ?? '-' }}</td>
                        <td>
                            @if ($customer->location_image)
                                @php
                                    $url = $customer->location_image->getUrl();
                                    $needle = 'uploads/';
                                    $insert = '/amari/public';
                                    $pos = strpos($url, $needle);
                                    if ($pos !== false) {
                                        $url = substr_replace($url, $insert . '/', $pos, 0);
                                    }
                                @endphp
                                <img src="{{ $url }}" alt="Location Image" class="img-thumbnail" style="max-width: 80px;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>

                        <td>
                            <div class="btn-group" role="group">
                                @can('customer_show')
                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan
                                @can('customer_edit')
                                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('customer_delete')
                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
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
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

    @can('customer_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.customers.massDestroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).nodes(), function(entry) {
                return $(entry).data('entry-id');
            });
            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}');
                return;
            }
            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                    headers: { 'x-csrf-token': _token },
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }
                }).done(function() { location.reload() });
            }
        }
    };
    dtButtons.push(deleteButton);
    @endcan

    $.extend(true, $.fn.dataTable.defaults, {
        orderCellsTop: true,
        order: [[1, 'desc']],
        pageLength: 50,
    });

    let table = $('.datatable-Customer:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
});
</script>
@endsection
