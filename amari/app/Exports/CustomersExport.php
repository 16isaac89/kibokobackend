<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, ShouldAutoSize
{
    private $customers;

    public function __construct()
    {
        $this->customers = Customer::with(['dealer', 'route'])->get();
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
        // Get the image URL and modify it as needed
        $url = $customer->location_image ? $customer->location_image->getUrl() : '';
        $needle = 'uploads/';
        $insert = 'amari/public';
        $pos = strpos($url, $needle);
        if ($pos !== false) {
            $url = substr_replace($url, $insert . '/', $pos, 0);
        }

        return [
            $customer->name ?? '',
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
            $url // Image URL in the last column
        ];
    }

    /**
     * Add headings to the Excel file.
     */
    public function headings(): array
    {
        return [
            'Name', 'Dealer', 'Route', 'CheckIN', 'Checkout', 'Telephone No', 'Phone', 'Email',
            'Area', 'City', 'Country', 'Classification', 'Cash Registers', 'Daily Footfall',
            'Product Range', 'Contact Person', 'Customer Category', 'B\'ss Value', 'Location',
            'Lat', 'Long', 'IMGlat', 'IMGlong', 'Image'
        ];
    }

    /**
     * Add images as drawings in the Excel file.
     */
    public function drawings()
    {
        $drawings = [];

        foreach ($this->customers as $index => $customer) {
            if ($customer->location_image) {
                // Generate the modified URL for the image
                $imageUrl = $customer->location_image->getUrl();
                $needle = 'uploads/';
                $insert = 'amari/public';
                $pos = strpos($imageUrl, $needle);
                if ($pos !== false) {
                    $imageUrl = substr_replace($imageUrl, $insert . '/', $pos, 0);
                }

                // Define a temporary full path for storing the image
                $tempImagePath = storage_path('app/public/temp_image_' . $customer->id . '.jpg');

                // Download the image to the defined path
                file_put_contents($tempImagePath, file_get_contents($imageUrl));

                $drawing = new Drawing();
                $drawing->setPath($tempImagePath);
                $drawing->setHeight(50); // Adjust height as needed
                $drawing->setCoordinates('X' . ($index + 2)); // Column 'X' for images, starting from row 2
                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

}
