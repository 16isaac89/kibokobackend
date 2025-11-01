<?php

namespace App\Exports;

use App\Models\StockRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PreordersExportGeneral  implements FromCollection, WithHeadings
{

    protected $month;
    protected $year;

    // Constructor to accept the date range
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $month = $this->month;
        $year = $this->year;
        return StockRequest::with(['items','dealer','van'=>function($query)use ($month, $year){
            $query->with(['target'=>function($query)use ($month, $year){
                $query->where(['month'=>$month,'year'=>$year]);
            },'stockrequests'=>function($query)use ($month, $year){
                $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            }]);
        },'customerroute'=>function($query)use ($month, $year){
            $query->with(['customers','updated_customers'=>function($query)use ($month, $year){
                $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            },'new_customers'=>function($query)use ($month, $year){
                $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            }]);
        },'saler','customer'])
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->whereHas('dealer', function($query) {
        $query->where('status', 0);
    })
        ->get()



        ->map(function ($preorder) {
            // Get routes and stock requests
        $routes = $preorder->dealer->routes;
        $requests = $preorder->van?->stockrequests;

        // Calculate total stock requests
        $requestTotal = $requests ? $requests->sum('total') : 0;

        // Prepare route information
        // $routeInfo = $routes->map(function ($route) {
        //     $customerCount = $route->customers->count(); // Count of customers
        //     return "{$route->name} ({$customerCount} Customers)";
        // })->join(', ');
            return [
                $preorder->dealer?->tradename ?? '',
                $preorder->saler?->username ?? '',
                $preorder->van?->name ?? '',
                $preorder->checkin ?? '',
                $preorder->checkout,
                $preorder->customerroute?->name ?? '',
                $preorder->customerroute->customers->count() ?? '',
                $preorder->customerroute->updated_customers->count(),
                $preorder->customerroute->new_customers->count(),
                //strike rate
                //$preorder->customerroute->new_customers->count(),
                    $preorder->items->count(),
                    $preorder->total,
                    $preorder->van->target?->money ?? '',
                    $requestTotal,
            ];
        });


    }
    public function headings(): array
    {
        return [
                        'Company',
                        'Executive',
                        'Van Name',
                        'Checkin',
                        'Checkout',
                        'Routes',
                        'Total Outlets',
                        'Visited Outlets',
                        'New Outlets',
                       // 'Strike Rate',
                        'Calls',
                        'Invoice Total',
                        'Sales Target',
                        'Target Achieved',
        ];
    }
}
