<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\Route;

class CustomerController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $dealer = Auth::guard('dealer')->user()->dealer;

        $customers = Customer::with('route')->where('dealer_code',$dealer->code)->get();
        $categories = CustomerCategory::all();
        $routes = Route::where('dealer_code',$dealer->code)->get();
        return view('dealer.customer.index',compact('customers','categories','routes'));
        }else{
            return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
        }
    }
    public function store(){
        if(\Auth::guard('dealer')->check()){
        $dealer = Auth::guard('dealer')->user()->dealer_id;
        Customer::create([
            'name'=>request()->name,
            'phone'=>request()->phone,
            'tin'=>request()->tin,
            'address'=>request()->address,
            'category_id'=>request()->category,
            'route_id'=>request()->route,
            'dealer_id'=>$dealer,
            'branch_id'=>Auth::guard('dealer')->user()->branch_id,
            'status'=>request()->status,
            'credit'=>request()->credit,
            'identification'=> uniqid(),
            'efrisstatus'=>request()->registered,
            'buyerType'=>request()->buyertype
        ]);
        return back();
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
}
