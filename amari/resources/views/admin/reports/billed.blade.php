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

        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered" id="customers-billed-table">
                <thead class="table-light">
                    <tr>
                        <th style="width: 30px;"></th>     {{-- empty --}}
                        <th style="width: 40px;"></th>     {{-- expand icon --}}
                        <th>Invoice No</th>
                        <th>Dealer</th>
                        <th>Route</th>
                        <th>Sales Rep</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        @php
                            $cleanItems = $invoice->items->map(function ($item) {
                                return [
                                    'product'  => $item->product->name ?? 'N/A',
                                    'qty'      => $item->appqty,
                                    'price'    => number_format($item->sellingprice, 2),
                                    'discount' => $item->discount ?? 0,
                                    'total'    => number_format($item->total, 2),
                                ];
                            });
                        @endphp

                        <tr class="invoice-row" data-items='@json($cleanItems)'>
                            <td></td>
                            <td class="details-control text-center" style="cursor:pointer; font-size:1.2em;">Expand</td>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->dealer->tradename ?? 'N/A' }}</td>
                            <td>{{ $invoice->customerroute->name ?? 'N/A' }}</td>
                            <td>{{ $invoice->saler->username ?? 'N/A' }}</td>
                            <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                            <td>{{ number_format($invoice->total, 2) }}</td>
                            <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                No invoices found for {{ $date }}
                            </td>
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

    // Initialize DataTable (you can add buttons, ordering, etc. here)
    let table = $('#customers-billed-table').DataTable({
        ordering: true,
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [0, 1] }, // disable sorting on the two first columns
        ]
    });

    // Expand / Collapse logic
    $('#customers-billed-table tbody').on('click', 'td.details-control', function () {
        let tr    = $(this).closest('tr');
        let row   = table.row(tr);

        if (row.child.isShown()) {
            // Close
            row.child.hide();
            tr.removeClass('shown');
            $(this).html('Expand');
        } else {
            // Open
            let items = JSON.parse(tr.attr('data-items'));

            let html = `
                <tr>
                    <td></td><td></td> <!-- match the two first columns -->
                    <td colspan="7" style="padding: 0;">
                        <div style="padding: 1rem; background:#f8f9fa;">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>`;

            items.forEach(item => {
                html += `
                    <tr>
                        <td>${item.product}</td>
                        <td>${item.qty}</td>
                        <td>${item.price}</td>
                        <td>${item.discount}</td>
                        <td>${item.total}</td>
                    </tr>`;
            });

            html += `
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>`;

            row.child(html).show();
            tr.addClass('shown');
            $(this).html('Collapse');
        }
    });

});
</script>
@endsection
