@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.customer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.id') }}
                        </th>
                        <td>
                            {{ $customer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.fullname') }}
                        </th>
                        <td>
                            {{ $customer->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.phone') }}
                        </th>
                        <td>
                            {{ $customer->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.email') }}
                        </th>
                        <td>
                            {{ $customer->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.address') }}
                        </th>
                        <td>
                            {{ $customer->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.username') }}
                        </th>
                        <td>
                            {{ $customer->username }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.image') }}
                        </th>
                        <td>
                            @if($customer->image)
                                <a href="{{ $customer->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $customer->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#customer_bookings" role="tab" data-toggle="tab">
                {{ trans('cruds.booking.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_customer_payments" role="tab" data-toggle="tab">
                {{ trans('cruds.customerPayment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_customer_wallets" role="tab" data-toggle="tab">
                {{ trans('cruds.customerWallet.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_invoices" role="tab" data-toggle="tab">
                {{ trans('cruds.invoice.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="customer_bookings">
            @includeIf('admin.customers.relationships.customerBookings', ['bookings' => $customer->customerBookings])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_customer_payments">
            @includeIf('admin.customers.relationships.customerCustomerPayments', ['customerPayments' => $customer->customerCustomerPayments])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_customer_wallets">
            @includeIf('admin.customers.relationships.customerCustomerWallets', ['customerWallets' => $customer->customerCustomerWallets])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_invoices">
            @includeIf('admin.customers.relationships.customerInvoices', ['invoices' => $customer->customerInvoices])
        </div>
    </div>
</div>

@endsection