@extends('layouts.admin')
@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Customers Billed</h5>
    </div>

    <div class="card-body">
        {{-- Date Filter --}}
        <form method="GET" class="mb-3 d-flex align-items-center gap-2 flex-wrap">
            <label for="date" class="mb-0">Select Date:</label>
            <input type="date" name="date" id="date" class="form-control w-auto" value="{{ $date }}">
            <button class="btn btn-success">Filter</button>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered" id="customers-billed-table">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Invoice No</th>
                         <th>Dealer</th>
                          <th>Route</th>
                           <th>Sales Rep</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Route</th>
                        <th>Date</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr data-toggle="collapse" data-target="#invoice-{{ $invoice->id }}" class="accordion-toggle">
                        <td></td>
                        <td>{{ $invoice->id }}</td>
                          <td>{{ $invoice->dealer->tradename ?? 'N/A' }}</td>
                         <td>{{ $invoice->customerroute->name ?? 'N/A' }}</td>
                        <td>{{ $invoice->saler->username ?? 'N/A' }}</td>
                        <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                        <td>{{ number_format($invoice->total, 2) }}</td>
                        <td>{{ $invoice->route }}</td>
                        <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="collapse" data-target="#invoice-{{ $invoice->id }}">
                                View Items
                            </button>
                        </td>
                    </tr>

                    {{-- Expandable Invoice Items --}}
                    <tr>
                        <td colspan="6" class="p-0">
                            <div class="collapse" id="invoice-{{ $invoice->id }}">
                                <div class="p-3">
                                    <table class="table table-sm table-bordered table-hover mb-0">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th></th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($invoice->items as $item)
                                            <tr>
                                                <td></td>
                                                <td>{{ $item->product->name ?? 'N/A' }}</td>
                                                <td>{{ $item->appqty }}</td>
                                                <td>{{ number_format($item->sellingprice, 2) }}</td>
                                                <td>{{ $item->discount ?? 0 }}</td>
                                                <td>{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No invoices found for {{ $date }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#customers-billed-table').DataTable({
            "order": [[0, "desc"]],
            "pageLength": 25,
            "lengthMenu": [10, 25, 50, 100],


        });
    });
</script>
@endsection
