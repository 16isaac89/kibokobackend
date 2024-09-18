<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\DealerUser;
use App\Models\Van;
use App\Models\Route;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(){
        $sales = Sale::with('dealer','user','van','route','items','customer')->get();
        return view('admin.reports.index',compact('sales'));
    }
    public function datatableindex(){
      
        $sales = Sale::with('dealer','user','van','route','items','customer')->get();
        return response()->json(["data"=>$sales]);
    }
    public function map(){
       
        $sales = Sale::with('dealer','user','van','route','items','customer')->get();
        return view('dealer.reports.map',compact('sales'));
    }
    public function trading(){
        $sales = DealerUser::with(['sales'=>function($q){
            $q->with('items')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        }])->get();
        return view('dealer.reports.trading',compact('sales'));
    }
    public function exec(){
       
        $sales = Sale::with('dealer','user','van','route','items','customer')->get();
        return view('admin.reports.exec',compact('sales'));
    }
    public function route(){
        $sales = Route::with(['customers','sales'=>function($q){
            $q->with('items','customer')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            }])->get();
        return view('admin.reports.route',compact('sales'));
    }
    public function van(){
        $sales = Van::with(['target'=>function($q){
            $q->whereMonth('month',Carbon::now()->month)->get();
        },
        'sales'=>function($q){
            $q->with('items','customer')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            },])->get();
        return view('admin.reports.van',compact('sales'));
    }
    public function rep(){
        $sales = DealerUser::with(['plans','target'=>function($q){
                                    $q->whereMonth('month', date('m'));
                                        },'sales'=>function($q){
                                    $q->with('items','customer')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                                    }])->get();
                                    //dd($sales);
        return view('admin.reports.rep',compact('sales'));
    }
    public function subd(){
        $sales = Sale::with('dealer','user','van','route','items','customer')->get();
        return view('admin.reports.subd',compact('sales'));
    }
}
