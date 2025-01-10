<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\TaxPayerController;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\Dealer;
use App\Models\Route;
use Auth;
use Illuminate\Http\Request;

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

    public function getTaxPayerDetails(Request $request){
        $tin2 = request()->tin;
        $dealerefris = Auth::guard('dealer')->user()->dealer;
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $payer = (new TaxPayerController)->getTaxPayer($deviceno,$tin,$privatek,$aeskey,$tin2);
        return response()->json(['taxpayer'=>$payer]);

    }
}
