<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\StockRequest;
use App\Models\StockRequestProduct;
use App\Exports\PreordersExport;
use Maatwebsite\Excel\Facades\Excel;

class PresaleOrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = StockRequestProduct::query();

        if ($request->from_date && $request->to_date) {
            $query->with(['product','dealer','tax','stockreqs'=>function(){
                $query->with('dealer','van','customer');
            }])->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $preorders = $query->get();
        return view('admin.presaleorders.index', compact('preorders'));
    }
    public function search(Request $request){
        $requesttype = $request->input('dealer');
        $status = $request->input('status');
        $orders = [];
        if($requesttype == '0' || $requesttype == 0){
            $orders = StockRequest::with(['dealer','customer'=>function($query){
                $query->with('route');
            },'items'=>function($query){
                $query->with(['product']);
           },'saler','van'])->where(['status'=>request()->status])->get();

        }else{
            $orders = StockRequest::with(['dealer','customer'=>function($query){
                $query->with('route');
            },'items'=>function($query){
                $query->with(['product']);
           },'saler','van'])->where(['status'=>request()->status,'dealer_id'=>$requesttype])->get();

        }
        return response()->json(['orders'=>$orders]);

    }

    public function searchByDate(Request $request)
    {
        $preorders = StockRequestProduct::with(['dealerproduct','product'=>function($query){
            $query->with('brand','tax');
        },'stockreqs'=>function($query){
            $query->with('dealer','van','customer','customerroute');
        }])->whereBetween('created_at', [$request->fromdate, $request->todate])->get();

        return response()->json(['preorders' => $preorders]);
    }
    public function exportPresale(Request $request)
    {
        //dd($request->all());
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $type = $request->input('type');
        switch ($type) {
            case 'csv':
                return Excel::download(new PreordersExport($fromDate, $toDate), 'preorders.csv');
            case 'excel':
                return Excel::download(new PreordersExport($fromDate, $toDate), 'preorders.xlsx');
        }
    }
}
