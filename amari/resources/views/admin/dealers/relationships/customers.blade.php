<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatable datatable-Customer">
        <thead>
            <tr>
                <th width="10"></th>
                <th>Route</th>
                <th>Customer</th>
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
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dealer->dealerclients as $key => $customer)
                <tr data-entry-id="{{ $customer->id }}">
                    <td></td>
                    <td>{{ $customer->route->name ?? '' }}</td>
                    <td>{{ $customer->name ?? '' }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $customer->telephoneno ?? '' }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $customer->phone ?? '' }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $customer->email ?? '' }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $customer->area ?? '' }}</td>
                    <td>{{ $customer->city ?? '' }}</td>
                    <td>{{ $customer->country ?? '' }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $customer->classification ?? '' }}</td>
                    <td>{{ $customer->cashregisters ?? '' }}</td>
                    <td>{{ $customer->dailyfootfall ?? '' }}</td>
                    <td>{{ $customer->productrange ?? '' }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $customer->contact_person ?? '' }}</td>
                    <td>{{ $customer->custcategory ?? '' }}</td>
                    <td>
                        @can('customer_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.customers.show', $customer->id) }}">
                                {{ trans('global.view') }}
                            </a>
                        @endcan

                        @can('customer_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.customers.edit', $customer->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                        @endcan

                        @can('customer_delete')
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
