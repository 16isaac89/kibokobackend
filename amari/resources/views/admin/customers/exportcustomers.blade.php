
            <table class="table table-bordered table-striped table-hover datatable datatable-Customer">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>Dealer</th>
                        <th>Route</th>
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
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $key => $customer)
                        <tr data-entry-id="{{ $customer->id }}">
                            <td></td>
                            <td>{{ $customer->dealer->tradename ?? '' }}</td>
                            <td>{{ $customer->route->name ?? '' }}</td>

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
