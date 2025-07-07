<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Dealer;
use App\Models\EfrisSetting;
use App\Models\Route;
use App\Models\StockRequestProduct;
use App\Models\Van;
use Carbon\Carbon;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Facades\DB;
class HomeController
{
    public function index()
    {
        $setting = EfrisSetting::find(1);
        $customers = Customer::all()->count();
        $vans = Van::all()->count();
        $routes = Route::all()->count();
        $dealers = Dealer::all()->count();
        $geotagged = Customer::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->where('latitude', '!=', '')
        ->where('longitude', '!=', '')
        ->count();

//dd(auth()->user()->dealers->pluck('id')->toArray());
$preorders = [];
$totalamountpresalestoday = 0;
$totalpresalestoday = 0;
if(auth()->user()->designation == 2){
    $dealerids = auth()->user()->dealers->pluck('id')->toArray();
    $preorders = StockRequestProduct::with([
        'dealerproduct',
        'product' => function($query) {
            $query->with('brand', 'tax');
        },
        'stockreqs' => function($query) {
            $query->with('saler', 'dealer', 'van', 'customer', 'customerroute');
        }
    ])
    ->whereHas('stockreqs', function($query) use ($dealerids) {
        $query->whereIn('dealer_id', $dealerids);
    })
    ->whereBetween('created_at', [
        Carbon::today()->startOfDay(),
        Carbon::today()->endOfDay()
    ])
    ->get();
  $totalamountpresalestoday = StockRequestProduct::whereHas('stockreqs', function($query) use ($dealerids) {
        $query->whereIn('dealer_id', $dealerids);
    })
    ->whereBetween('created_at', [
        Carbon::today()->startOfDay(),
        Carbon::today()->endOfDay()
    ])
    ->sum('total');
    $totalpresalestoday = StockRequestProduct::whereHas('stockreqs', function($query) use ($dealerids) {
        $query->whereIn('dealer_id', $dealerids);
    })
        ->whereBetween('created_at', [
            Carbon::today()->startOfDay(),
            Carbon::today()->endOfDay()
        ])
        ->count();
}else{
 $preorders = StockRequestProduct::with([
            'dealerproduct',
            'product' => function($query) {
                $query->with('brand', 'tax');
            },
            'stockreqs' => function($query) {
                $query->with('saler', 'dealer', 'van', 'customer', 'customerroute');
            }
        ])
        ->whereBetween('created_at', [
            Carbon::today()->startOfDay(),
            Carbon::today()->endOfDay()
        ])
        ->get();
    $totalamountpresalestoday = StockRequestProduct::whereBetween('created_at', [
            Carbon::today()->startOfDay(),
            Carbon::today()->endOfDay()
        ])
        ->sum('total');
    $totalpresalestoday = StockRequestProduct::whereBetween('created_at', [
            Carbon::today()->startOfDay(),
            Carbon::today()->endOfDay()
        ])
        ->count();
}


$presales = StockRequestProduct::select('id', 'created_at')
->get()
->groupBy(function($date) {
    return Carbon::parse($date->created_at)->format('m'); // grouping by months
});

$ordersmcount = [];
$ordersArr = [];

foreach ($presales as $key => $value) {
    $ordersmcount[(int)$key] = count($value);
}

for($i = 1; $i <= 12; $i++){
    if(!empty($ordersmcount[$i])){
        $ordersArr[$i] = $ordersmcount[$i];
    }else{
        $ordersArr[$i] = 0;
    }
}
$preordersmonth = $ordersArr;



        return view('home', compact('preordersmonth','preorders','customers','vans','routes','dealers','geotagged','totalamountpresalestoday','totalpresalestoday',));
    }
}
