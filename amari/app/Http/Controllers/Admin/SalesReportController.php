<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Van;
use Carbon\Carbon;
use App\Models\Dispatch;
use App\Models\Summarydaybook;
use App\Models\SaleProduct;

class SalesReportController extends Controller
{
    public function index(){
        $results = array();
return view('admin.salesreport.index',compact('results'));
    }
    public function indexsearch(){
        $from = date(request()->fromdate);
        $to = date(request()->todate);
        $results = Van::with(['summarydaybook'=>function($query)use ($from,$to){
            $query->whereBetween('created_at', [$from, $to]);
        }])
        ->get();
        return view('admin.salesreport.index',compact('results'));
    }
    public function searchreports(){
        $from = date(request()->fromdate);
        $to = date(request()->todate);
        $results = Van::with(['summarydaybook'=>function($query)use ($from,$to){
                        $query->whereBetween('created_at', [$from, $to]);
                    }])
                    ->get();
                  
        return view('admin.salesreport.index',compact('results'));
    }
    public function customerpfm(){
        $vans = Van::all();
        $reports = [];
        return view('admin.salesreport.customer',compact('vans','reports'));
    }
    public function searchcustomerpfm(){
        $vans = Van::all();
        $from = date(request()->fromdate);
        $to = date(request()->todate);
        $reports = SaleProduct::with(['client'=>function($query){
            $query->with('route');
        }])->where('van',request()->vanid)->whereBetween('created_at', [$from, $to])->get();
//         foreach($reports as $report){
// dd($report->customer);
//         }
       // dd($reports);
        return view('admin.salesreport.customer',compact('vans','reports'));
    }
    public function daybook(){
        $vans = Van::all();
        $results = array();
        return view('admin.salesreport.daybook',compact('vans','results'));
    }
    public function searchdaybook(){
        //dd(request()->all());
        $vans = Van::all();
        $from = date(request()->fromdate);
        $to = date(request()->todate);
        $vanid = request()->vanid;
        $results = SaleProduct::with(['product'=>function($query)use($from,$to){
            $query->with(['stocks'=>function($query)use($from,$to){ $query->whereBetween('receivedate',[$from,$to]);}]);
        }])->whereHas('sale',function($query)use($vanid){
            $query->where('van_id', $vanid);
        })->get();
        //dd($results);
        return view('admin.salesreport.daybook',compact('vans','results'));
    }
    public function summarydaybook(){
        $results = array();
        return view('admin.salesreport.summarydaybook',compact('results'));
    }
    public function summarydaybookadd(){
        $vans = Van::all();
        return view('admin.salesreport.summaryadd',compact('vans'));
    }
    public function summarydaybooksearch(){
        $from = date(request()->fromdate);
        $to = date(request()->todate);
        $results = summarydaybook::with('van')->whereBetween('created_at', [$from, $to])->get();

        return view('admin.salesreport.summarydaybook',compact('results'));
    }
    public function getvan(){
        $date = Carbon::now();
        $van = request()->van;
        $formatedDate = $date->format('Y-m-d');
        $dispatch = Dispatch::where('van_id',$van)->whereDate('created_at',$formatedDate)->first();
        return response()->json(['dispatch'=>$dispatch]);
    }
    public function addsummary(){
        $date = Carbon::now();
        $formatedDate = $date->format('Y-m-d');
        $summary = Summarydaybook::where('van_id',request()->vanid)->whereDate('created_at',$formatedDate)->first();
        if($summary){
            return \Redirect::back()->withErrors(['error' => 'Already created one for this van today']);
        }else{
            Summarydaybook::create([
                'van_id'=>request()->vanid,
                'expected'=>request()->expected,
                'received'=>request()->received,
                'difference'=>request()->difference,
                'comment'=>request()->comment,
                'dispatch_id'=>request()->dispatchid,
                ]);
                return redirect()->back()->with('success', 'Summary day book created successfully');     
        }
        
    }


}
