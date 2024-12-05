<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\RepRoute;
use App\Models\Route;
use App\Models\RoutePlanList;
use App\Models\Van;
use Auth;
use Illuminate\Http\Request;

class RoutePlanController extends Controller
{
    public function index()
    {
        if (\Auth::guard('dealer')->check()) {
            $dealer = Auth::guard('dealer')->user()->dealer;
            //dd($dealer);
            $van = Van::with('dealerusers')->find(request()->van);
            $routes = Route::where('dealer_code', $dealer->code)->get();

            //dd(count(RoutePlanList::where(['dealer_user_id'=>"2",'week'=>4,'day'=>1])->get()));
            return view('dealer.route.plan', compact('van', 'routes'));
        } else {
            return redirect()->route("dealer.login.view")->with('status', 'Opps! You have entered invalid credentials');
        }
    }
    public function getCustomer()
    {
        $customers = Customer::where('route_code', request()->route)->get();
        $route = Route::where('code', request()->route)->first();
        $assignedcustomers = RoutePlanList::where(['route_id' => $route->code, 'week' => request()->week,
        'day' => request()->day, 'dealer_user_id' => request()->user,'van_id' => request()->van])->pluck("customer_id");
        return response()->json(['customers' => $customers,'assignedcustomers' => $assignedcustomers]);
    }
    public function store()
    {
      //  dd(request()->all());
        $dealer = Auth::guard('dealer')->user()->dealer_id;
        $route = Route::where('code', request()->route)->get()->first();

        $reproute = RepRoute::with('list')->where(['dealer_user_id' => request()->user, 'route_id' => request()->route,
        'day' => request()->day, 'week' => request()->week, 'van_id' => request()->van])->first();
     //  dd($reproute);
       // $routerep = RepRoute::where(['dealer_user_id' => request()->user, 'route_id' => request()->route])->first();

       // if ($routerep === null) {
       //     $route = Route::where('code', request()->route)->get()->first();
       //dd($reproute);
       if ($reproute) {


        $reproute->list()->forceDelete();
        $reproute->forceDelete();
    }

         $reproute = RepRoute::create([
                'dealer_user_id' => request()->user,
                'route_id' => request()->route,
                'name' => $route->name,
                'van_id'=> request()->van,
                'day'=>request()->day,
                'week'=>request()->week,
            ]);
       // }

        if (request()->customer) {
            foreach (request()->customer as $cust) {
                $customer = Customer::with('route')->find($cust);
                RoutePlanList::create([
                    'customer_id' => $cust,
                    'name' => $customer->name,
                    'routename' => $route->name,
                    'route_id' => request()->route,
                    'dealer_user_id' => request()->user,
                    'dealer_id' => $dealer,
                    'week' => request()->week,
                    'day' => request()->day,
                    'rep_route_id' => $reproute->id,
                    'van_id' => request()->van
                ]);
            }
        }
        return redirect()->back()->with('message', 'Route Plan Created Successfully');
    }
}
