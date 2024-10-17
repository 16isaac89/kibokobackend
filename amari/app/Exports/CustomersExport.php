<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Fetch customers with necessary relationships
        return Customer::with(['dealer', 'route'])->get()->map(function ($customer) {
            return [
                $customer->dealer->tradename ?? '',
                $customer->route->name ?? '',
                $customer->customercheckin ?? '',
                $customer->customercheckout ?? '',
                $customer->telephoneno ?? '',
                $customer->phone ?? '',
                $customer->email ?? '',
                $customer->area ?? '',
                $customer->city ?? '',
                $customer->country ?? '',
                $customer->classification ?? '',
                $customer->cashregisters ?? '',
                $customer->dailyfootfall ?? '',
                $customer->productrange ?? '',
                $customer->contact_person ?? '',
                $customer->custcategory ?? '',
                $customer->businessvalue ?? '',
                $customer->location ?? '',
                $customer->latitude,
                $customer->longitude,
                $customer->subdimagelat,
                $customer->subdimagelong,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Dealer', 'Route', 'CheckIN', 'Checkout', 'Telephone No', 'Phone', 'Email',
            'Area', 'City', 'Country', 'Classification', 'Cash Registers', 'Daily Footfall',
            'Product Range', 'Contact Person', 'Customer Category', 'B\'ss Value', 'Location',
            'Lat', 'Long', 'IMGlat', 'IMGlong'
        ];
    }
}

