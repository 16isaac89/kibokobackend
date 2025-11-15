<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, ShouldQueue
{
    private $customers;

    public function __construct()
    {
        $this->customers = Customer::with(['dealer', 'route'])
     //   ->whereHas('dealer', function($query) {
     //   $query->where('status', 1);
   // })
	->get();
    }

    /**
     * Collection of customers.
     */
    public function collection()
    {
        return $this->customers;
    }

    /**
     * Map each customer's data to a row.
     */
    public function map($customer): array
    {
        // Get the image URL, and modify it if needed
        $url = $customer->location_image ? $customer->location_image->getUrl() : '';
        $needle = 'uploads/';
        $insert = 'amari/public';
        $pos = strpos($url, $needle);
        if ($pos !== false) {
            $url = substr_replace($url, $insert . '/', $pos, 0);
        }

        return [
            $customer->dealer->tradename ?? '',
            $customer->route->name ?? '',
            $customer->name ?? '',
            $customer->dealer?->headsupervisor?->username ?? '',
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
            $url // Include image URL instead of image
        ];
    }

    /**
     * Add headings to the Excel file.
     */
    public function headings(): array
    {
        return [
            'Dealer', 'Route','Name','Dealer Head','CheckIN', 'Checkout', 'Telephone No', 'Phone', 'Email',
            'Area', 'City', 'Country', 'Classification', 'Cash Registers', 'Daily Footfall',
            'Product Range', 'Contact Person', 'Customer Category', 'B\'ss Value', 'Location',
            'Lat', 'Long', 'IMGlat', 'IMGlong', 'Image URL' // Updated heading to "Image URL"
        ];
    }
}

