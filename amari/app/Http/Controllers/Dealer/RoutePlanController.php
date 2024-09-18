<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Van;
use App\Models\Route;
use App\Models\Customer;
use Auth;
use App\Models\RoutePlan;
use App\Models\RoutePlanList;
use App\Models\RepRoute;

class RoutePlanController extends Controller
{
   public function index(){
    if(\Auth::guard('dealer')->check()){
    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $van = Van::with('dealerusers')->find(request()->van);
    $routes = Route::where('dealer_id',$dealer)->get();

    //dd(count(RoutePlanList::where(['dealer_user_id'=>"2",'week'=>4,'day'=>1])->get()));
    return view('dealer.route.plan',compact('van','routes'));
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
   }
   public function getCustomer(){
    $customers = Customer::where('route_id',request()->route)->get();
    return response()->json(['customers'=>$customers]);
   }
public function store(){
$dealer = Auth::guard('dealer')->user()->dealer_id;
$routerep = RepRoute::where(['dealer_user_id'=>request()->user,'route_id'=>request()->route])->first();

if ($routerep === null) {
    RepRoute::create([
        'dealer_user_id'=>request()->user,
        'route_id'=>request()->route,
        'name'=>Route::find(request()->route)->name
    ]);
 }

if(request()->customer){
foreach(request()->customer as $cust){
$customer = Customer::with('route')->find($cust);
RoutePlanList::create([
    'customer_id'=>$customer->identification,
    'name'=>$customer->name,
    'routename'=>$customer->route->name,
    'route_id'=>request()->route,
    'dealer_user_id'=>request()->user,
    'dealer_id'=>$dealer,
    'week'=>request()->week,
    'day'=>request()->day,
]);
}
}
return back();
   }
}
