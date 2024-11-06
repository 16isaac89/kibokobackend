<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\StockRequestProduct;

class PreordersExportDealer implements FromCollection, WithHeadings
{

    protected $fromDate;
    protected $toDate;
    protected $dealer_id;

    // Constructor to accept the date range
    public function __construct($fromDate, $toDate,$dealer_id)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->dealer_id = $dealer_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StockRequestProduct::with([
            'dealerproduct',
            'product' => function($query) {
                $query->with('brand', 'tax');
            },
            'stockreqs' => function($query) {
                $query->with('saler', 'dealer', 'van', 'customer', 'customerroute');
            }
        ])->whereBetween('created_at', [$request->fromdate, $request->todate])
          ->whereHas('stockreqs', function($query) use ($dealerId) {
              $query->where('dealer_id', $dealerId);
          })->get()
        ->map(function ($preorder) {
            return [
                $preorder->stockreqs->id ?? '', // Invoice No
                $preorder->stockreqs->created_at->format('Y-m-d'), // Invoice Date
                $preorder->stockreqs->saler?->username ?? '',
                $preorder->stockreqs->customer->name ?? '', // Customer Name
                $preorder->stockreqs->dealer->tradename, // Executive Name
                $preorder->product->code, // Product Code
                $preorder->reqqty,
                $preorder->product->description ?? '', // Item Description
                $preorder->sellingprice, // Basic Value
                $preorder->product->tax_amount, // VAT Value
                $preorder->total, // Total Sales
                $preorder->stockreqs->customerroute->name, // Route
                $preorder->stockreqs->checkin, // In Time
                $preorder->stockreqs->checkout // Out Time
            ];
        });


    }
    public function headings(): array
    {
        return [
            'Invoice No',
            'Invoice Date',
            'Customer Name',
            'Dealer',
            'Executive Name',
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
