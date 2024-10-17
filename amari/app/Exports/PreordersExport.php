<?php

namespace App\Exports;

use App\Models\StockRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class PreordersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StockRequest::all();
    }
}
