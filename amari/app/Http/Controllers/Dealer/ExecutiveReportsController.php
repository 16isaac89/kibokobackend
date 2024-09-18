<?php

namespace App\Http\Controllers\dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\DealerUser;
use App\Models\Route;
use App\Models\Van;
use Carbon\Carbon;
use App\Models\ProductBrand;

class ExecutiveReportsController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $sales = Sale::with('dealer','user','van','route','items','customer')
        ->where('dealer_id',$dealer)
        ->get();
        return view('dealer.reports.index',compact('sales'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function searchsales(){
        if(\Auth::guard('dealer')->check()){
            $from = date(request()->from);
            $to = date(request()->to);
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $sales = Sale::with('dealer','user','van','route','items','customer')
                            ->whereBetween('created_at', [$from, $to])
                            ->where('dealer_id',$dealer)
                            ->get();
        return view('dealer.reports.index',compact('sales'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function datatableindex(){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $sales = Sale::with('dealer','user','van','route','items')->where('dealer_id',$dealer)->get();
        return response()->json(["data"=>$sales]);
    }
    public function map(){
        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $sales = Sale::with('dealer','user','van','route','items','customer')->where('dealer_id',$dealer)->get();
        //dd($sales);
        return view('dealer.reports.map',compact('sales'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function trading(){
        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $sales = DealerUser::with(['sales'=>function($q){
            $q->with('items')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        }])->where('dealer_id',$dealer)->get();
        return view('dealer.reports.trading',compact('sales'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function exec(){
        if(\Auth::guard('dealer')->check()){
        $today = Carbon::now()->format('Y-m-d');
        $day = Carbon::now()->dayOfWeek;
        $week = Carbon::now()->weekNumberInMonth;
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $sales  = DealerUser::with(['sales'=>function($query)use($today){
            $query->with('route','items','customer')->whereDate('created_at', date($today));
        },'plans'=>function($query)use($day,$week){
$query->with('route')->where(['day'=>$day,'week'=>$week]);
        },'logins'=>function($query)use($today){
            $query->whereDate('created_at', Carbon::today());
        }])->where('dealer_id',$dealer)->get();
        return view('dealer.reports.exec',compact('sales','today'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function searchexec(){
        if(\Auth::guard('dealer')->check()){
            $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $from = request()->from;
        $to = request()->to;
        $sales  = DealerUser::with(['sales'=>function($query)use($today){
            $query->with('route','items','customer')->whereBetween('created_at', [$from, $to]);
        },'plans'=>function($query)use($year,$month){
$query->with('route')->whereMonth('created_at', $month)->whereYear('created_at',$year);
        },'logins'=>function($query)use($today){
            $query->whereDate('created_at', date($today));
        }])->where('dealer_id',$dealer)->get();
        return view('dealer.reports.exec',compact('sales','today'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function route(){
        if(\Auth::guard('dealer')->check()){
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;

        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $sales = Route::with(['customers',
        'sales'=>function($q)use($month,$year){
                            $q->with('items','customer')->whereMonth('created_at',$month)->whereYear('created_at',$year);
                            },
                            'routeplans'=>function($query)use($month,$year){
                                $query->with(['saler'=>function($query)use($month,$year){
                                    $query->with([
                                        'target'=>function($query)use($month,$year){
                                            $query->where(['month'=>$month,'year'=>$year]);
                                        }
                                    ]);
                                }]);
                            }
                            ])
                             ->where('dealer_id',$dealer)
                            ->get();
                            //dd($sales);
        return view('dealer.reports.route',compact('sales','month','year'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function searchroute(){
        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $month = request()->month;
        $year = request()->year;
        $sales = Route::with(['customers',
        'sales'=>function($q)use($month,$year){
                            $q->with('items','customer')->whereMonth('created_at',$month)->whereYear('created_at',$year);
                            },'routeplans'=>function($query)use($month,$year){
                                $query->with(['saler'=>function($query)use($month,$year){
                                    $query->with([
                                        'target'=>function($query)use($month,$year){
                                            $query->where(['month'=>$month,'year'=>$year]);
                                        }
                                    ]);
                                }]);
                            }])
                             ->where('dealer_id',$dealer)
                            ->get();
                            //dd($sales);
                            //dd($sales);
        return view('dealer.reports.route',compact('sales','month','year'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function getroutesales(){
        $sales = Sale::with('route','user','items','customer')->where('route_id',request()->route)
                       ->whereMonth('created_at',request()->month)
                       ->whereYear('created_at',request()->year)
                       ->get();
        return response()->json(['sales'=>$sales]);
    }


    public function van(){

        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $sales = Van::with(['target'=>function($q)use($month,$year){
            $q->where('month',$month);
        },
        'sales'=>function($q)use($month,$year){
            $q->with('items','customer')->whereMonth('created_at',$month)->whereYear('created_at',$year);
            },'dealerusers'=>function($query)use($month,$year){
                $query->with(['target'=>function($query)use($month,$year){
                    $query->where('month',$month)->where('year',$year);
                }]);
            },'routeplan'])
            ->where('dealer_id',$dealer)
            ->get();

        return view('dealer.reports.van',compact('sales','month','year'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function brand(){

        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $sales = ProductBrand::with(['salesproducts'=>function($query)use($month,$year){
            $query->whereMonth('created_at',$month)->whereYear('created_at',$year);
        }])
        ->where('dealer_id',$dealer)
            ->get();
        // dd($sales);
        return view('dealer.reports.brand',compact('sales','month','year'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function searchbrandreport(){

        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $month = request()->month;
        $year = request()->year;
        $sales = ProductBrand::with(['salesproducts'=>function($query)use($month,$year){
            $query->whereMonth('created_at',$month)->whereYear('created_at',$year);
        }])
            ->get();
        // dd($sales);
        return view('dealer.reports.brand',compact('sales','month','year'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }


    public function searchvan(){

        if(\Auth::guard('dealer')->check()){
            $month = request()->month;
            $year = request()->year;
            $sales = Van::with(['target'=>function($q)use($month,$year){
                $q->where('month',$month);
            },
            'sales'=>function($q)use($month,$year){
                $q->with('items','customer')->whereMonth('created_at',$month)->whereYear('created_at',$year);
                },'dealerusers'=>function($query)use($month,$year){
                    $query->with(['target'=>function($query)use($month,$year){
                        $query->where('month',$month)->where('year',$year);
                    }]);
                },'routeplan'])
                ->where('dealer_id',$dealer)
                ->get();

            return view('dealer.reports.van',compact('sales','month','year'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function rep(){
        if(\Auth::guard('dealer')->check()){
            $month  = Carbon::now()->month;
            $year = Carbon::now()->year;
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $sales = DealerUser::with(['plans','target'=>function($q)use($month,$year){
                        $q->where('month',$month);
        },'sales'=>function($q)use($month,$year){
            $q->with('items','customer')->whereMonth('created_at',$month)->whereYear('created_at',$year);
            }])
            ->where(['dealer_id'=>$dealer])
            ->get();
            //dd($sales);
        return view('dealer.reports.rep',compact('sales','month','year'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function searchrep(){
        if(\Auth::guard('dealer')->check()){
            $month  = request()->month;
            $year = request()->year;
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        $sales = DealerUser::with(['plans','target'=>function($q)use($month,$year){
                        $q->where('month',$month);
        },'sales'=>function($q)use($month,$year){
            $q->with('items','customer')->whereMonth('created_at',$month)->whereYear('created_at',$year);
            }])
            ->where('dealer_id',$dealer)
            ->get();
           // dd($sales);
        return view('dealer.reports.rep',compact('sales','month','year'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function getrepsales(){
        $sales = Sale::with('route','user','items','customer')->where('dealer_user_id',request()->rep)
                       ->whereMonth('created_at',request()->month)
                       ->whereYear('created_at',request()->year)
                       ->get();
        return response()->json(['sales'=>$sales]);
    }
    public function getvansales(){
        $sales = Sale::with('route','user','items','customer')->where('van_id',request()->van)
                       ->whereMonth('created_at',request()->month)
                       ->whereYear('created_at',request()->year)
                       ->get();
        return response()->json(['sales'=>$sales]);
    }
    public function getbrandsales(){
        $sales = SaleProduct::where('product_brand_id',request()->brand)
                        ->whereMonth('created_at',request()->month)
                        ->whereYear('created_at',request()->year)
                       ->get();
        return response()->json(['sales'=>$sales]);
    }
    public function items(){
        $id = request()->id;
        $items = SaleProduct::with('product')->where('sale_id',$id)->get();
        return response()->json(['items'=>$items]);
    }
}
