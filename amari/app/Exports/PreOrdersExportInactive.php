<?php

namespace App\Exports;

use App\Models\StockRequestProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PreordersExportInactive  implements FromCollection, WithHeadings
{

    protected $fromDate;
    protected $toDate;

    // Constructor to accept the date range
    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
{
    return StockRequestProduct::with([
        'dealerproduct',
        'product.brand',
        'product.tax',
        'stockreqs.dealer',
        'stockreqs.van',
        'stockreqs.customer',
        'stockreqs.customerroute',
        'stockreqs.saler',
    ])
    ->whereBetween('created_at', [$this->fromDate, $this->toDate])
    ->whereHas('stockreqs', function ($query) {
        $query->whereHas('dealer', function ($q) {
            $q->where('status', 0); // Only active dealers
        });
    })
    ->get()
    ->map(function ($preorder) {
        $req = $preorder->stockreqs;

        return [
            $req->id ?? '', // Invoice No
            optional($req->created_at)->format('Y-m-d'), // Invoice Date
            $req->customer->name ?? '', // Customer Name
            $req->saler->username ?? '',
            $req->dealer->tradename ?? '', // Executive Name
            $preorder->product->code ?? '', // Product Code
            $preorder->reqqty,
            $preorder->product->name ?? '', // Item Description
            $preorder->sellingprice, // Basic Value
            $preorder->product->tax_amount ?? 0, // VAT Value
            $preorder->total, // Total Sales
            $req->customerroute->name ?? '', // Route
            $req->checkin ?? '', // In Time
            $req->checkout ?? '', // Out Time
        ];
    });
}

    public function headings(): array
    {
        return [
            'Invoice No',
            'Invoice Date',
            'Outlet Name',
            'Executive Name',
            'Dealer',

            'Product Code',
            'Quantity',
            'Item Description',
            'Basic Value',
            'VAT Value',
            'Total Sales',
            'Route',
            'In Time',
            'Out Time'
        ];
    }
}
