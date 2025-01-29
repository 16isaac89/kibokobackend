<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Route;

class RouteController extends Controller
{
    public function index(){
        $branch = Auth::guard('dealer')->user()->dealer_id;
        $routes = Route::where('dealer_id',$branch)->get();
        return view('dealer.route.index',compact('routes'));
    }
    public function store(){
        $dealer = Auth::guard('dealer')->user()->dealer_id;
        $branch = Auth::guard('dealer')->user()->branch_id;
       // dd(Auth::guard('dealer')->user()->dealer->code);
        Route::create([
            'name'=>request()->name,
            'dealer_id'=>$dealer,
            'branch_id'=>$branch,
            'code'=>Auth::guard('dealer')->user()->dealer->code,
            'dealer_code'=>Auth::guard('dealer')->user()->dealer->code,
        ]);
        return redirect()->back()->with('message','Route created successfully');
    }
    public function updateRoute(){
        Route::find(request()->routeid)->update([
            'name'=>request()->routename
        ]);
        return back();
    }
}
