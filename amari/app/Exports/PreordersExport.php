<?php

namespace App\Exports;

use App\Models\StockRequestProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PreordersExport  implements FromCollection, WithHeadings
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
        return StockRequestProduct::with(['dealerproduct','product'=>function($query){
            $query->with('brand','tax');
        },'stockreqs'=>function($query){
            $query->with('dealer','van','customer','customerroute','saler');
        }])->whereBetween('created_at', [$this->fromDate, $this->toDate])->get()
        ->map(function ($preorder) {
            return [
                $preorder->stockreqs->id ?? '', // Invoice No
                $preorder->stockreqs->created_at->format('Y-m-d'), // Invoice Date
                $preorder->stockreqs->saler?->username ?? '',
                $preorder->stockreqs->customer->name ?? '', // Customer Name
                $preorder->stockreqs->dealer->tradename, // Executive Name
                $preorder->product->code, // Product Code
                $preorder->product->description ?? '', // Item Description
                $preorder->sellingprice, // Basic Value
                $preorder->product->tax->value, // VAT Value
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
            'Sales Person',
            'Executive Name',
            'Product Code',
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
