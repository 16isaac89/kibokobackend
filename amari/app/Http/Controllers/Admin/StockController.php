<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockRequest;
use App\Models\Product;
use App\Models\LocationProduct;
use App\Models\Van;
use App\Models\StockRequestProduct;


class StockController extends Controller
{
   
    public function request(){
        $stockrequests = [];
        $vans = Van::all();
        return view('admin.stockmovements.request',compact('stockrequests','vans'));
    }
    public function requestsearch(){
        $vans = Van::all();
        $from = request()->fromdate;
        $to = request()->todate;
        $van = request()->van;
        $stockrequests = StockRequestProduct::with('product')->where('van_id',$van)->whereBetween('created_at',[$from, $to])->get();
       // dd($stockrequests);
        return view('admin.stockmovements.request',compact('stockrequests','vans'));
    }

    public function hold(){
        $products = [];
        return view('admin.stockmovements.hold',compact('products'));
    }
    public function detailedsearch(){
        $location = request()->location;
         $products = Product::with(['locationproducts'=>function($query)use($location){
            $query->with('location')->where('location_id',$location);
        },'dispatchproducts'])->get();
        return view('admin.stockmovements.hold',compact('products'));
    }
    
    public function count(){
        $products = [];
        $date="";
        // $products = Product::with(['locationproducts'=>function($query){
        //     $query->with('location');
        // }])->get();
       // dd($product);
        return view('admin.stockmovements.count',compact('products','date'));
    }
    public function searchcount(){
        $date = date(request()->date);
       $products = Product::with(['locationproducts'=>function($query){
            $query->with('location')->whereDate('countdate',request()->date);
        },'damagesexp'=>function($query){
            $query->whereDate('date',request()->date);
        },'dispatchproducts'=>function($q)use($date){
            $q->with('van')->whereDate('created_at', $date);
        }])->get();
      // dd($products);
        return view('admin.stockmovements.count',compact('products','date'));
    }
    public function vanmovement(){
        $vans = Van::all();
        $reports = [];
        return view('admin.stockmovements.vanmovement',compact('vans','reports'));
    }
    public function gstock(){
        $products = [];
        return view('admin.stockmovements.gstockhold',compact('products'));
    }
   
    public function searchgstockhold(){
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $from = request()->fromdate;
        $to = request()->todate;
        $products = Product::with(['stocks'=>function($query)use($from,$to){
            $query->whereBetween('period', [$from, $to]);
        },'dispatchproducts'=>function($query)use($from,$to){
            $query->whereBetween('created_at', [$from, $to]);
        }])->get();
        //dd($products);
        return view('admin.stockmovements.gstockhold',compact('products'));
    }

    public function vanmovementsearch(){
       // dd(request()->all());
       $vans = Van::all();
        $van = request()->van;
        $from = date(request()->fromdate);
        $to = date(request()->todate);
        $reports = Product::with(['dispatchproducts'=>function($q)use($van,$from,$to){
            $q->where('van_id',$van)->whereBetween('created_at', [$from, $to]);
        },'stockcount'=>function($q)use($from,$to){
            $q->whereBetween('date', [$from, $to])->sum('count');
        },'returns'=>function($q)use($van,$from,$to){
            $q->where('van_id',$van)->whereBetween('return_date', [$from, $to]);
        },'sales'=>function($q)use($van,$from,$to){
            $q->where('van',$van)->whereBetween('created_at', [$from, $to]);
        },'dispatchcounts'=>function($q)use($van,$from,$to){
            $q->where('van_id',$van)->whereBetween('created_at', [$from, $to]);
        }])->get();
        return view('admin.stockmovements.vanmovement',compact('vans','reports'));
        //dd($reports);
    }
}
