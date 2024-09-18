<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use App\Models\Route;
use App\Models\Van;
use App\Models\Sale;
use DB;
use App\Models\Dealer;


class HomeController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $dealer = Auth::guard('dealer')->user()->dealer_id;
        $efris = Dealer::find($dealer)->efris;
        $updatedat = Dealer::find($dealer)->updated_at;
        $customers = Customer::where('dealer_id',$dealer)->count();
        $vans = Van::where('dealer_id',$dealer)->count();
        $routes = Route::where('dealer_id',$dealer)->count();

        $latests = Sale::with('route','van','user','customer')->where('dealer_id',$dealer)->latest()->take(10)->get();


        $orderbarchart = Sale::select(DB::raw("COUNT(*) as count"), DB::raw("MONTH(created_at) as month_number"))
        ->whereYear('created_at', date('Y'))
        ->where('dealer_id',$dealer)
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('count', 'month_number');
        $barlabels = $orderbarchart->keys();
        $bardata = $orderbarchart->values();

        $orderlinechart = Sale::select(DB::raw("SUM(total) as sum"), DB::raw("MONTH(created_at) as month_number"))
        ->whereYear('created_at', date('Y'))
        ->where('dealer_id',$dealer)
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('sum', 'month_number');
        $linelabels = $orderlinechart->keys();
        $linedata = $orderlinechart->values();
       // dd($orderbarchart,$orderlinechart);
        return view('dealer.index',compact('routes','vans','customers','latests','barlabels','bardata','linelabels','linedata','efris','dealer','updatedat'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

}
