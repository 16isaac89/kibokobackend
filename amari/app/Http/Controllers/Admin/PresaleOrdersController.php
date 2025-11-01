<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\StockRequest;
use App\Models\StockRequestProduct;
use App\Exports\PreordersExport;
use App\Exports\PreordersExportInactive;
use App\Exports\PreordersExportGeneral;
use App\Exports\PreordersExportGeneralInactive;
use App\Exports\PreordersExportDealer;
use App\Exports\PreordersExportDealerInactive;
use Maatwebsite\Excel\Facades\Excel;

class PresaleOrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = StockRequestProduct::query();

        if ($request->from_date && $request->to_date) {
            $query->with(['product','dealer','tax','stockreqs'=>function(){
                $query->with('dealer','van','customer','saler');
            }])->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $preorders = $query->get();
        //dd('d');
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
            $query->with('saler','dealer','van','customer','customerroute');
        }])->whereBetween('created_at', [$request->fromdate, $request->todate])->get();

        return response()->json(['preorders' => $preorders]);
    }
    public function searchByDateDealer(Request $request)
    {
        $dealerId = $request->input('dealer_id');
        $preorders = StockRequestProduct::with([
            'dealerproduct',
            'product' => function($query) {
                $query->with('brand', 'tax');
            },
            'stockreqs' => function($query) {
                $query->with('saler', 'dealer', 'van', 'customer', 'customerroute');
            }
        ])->whereBetween('created_at', [$request->fromdate, $request->todate])
          ->whereHas('stockreqs', function($query) use ($dealerId) {
              $query->where('dealer_id', $dealerId);
          })
          ->get();

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
            case 'excelinactive':
                return Excel::download(new PreordersExportInactive($fromDate, $toDate), 'preordersinactive.xlsx');
        }
    }
    public function exportPresaleDealer(Request $request)
    {
        //dd($request->all());
        $dealer_id = $request->input('dealer_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $type = $request->input('type');
        $dealer_id = $request->input('dealer_id');
        switch ($type) {
            case 'csv':
                return Excel::download(new PreordersExportDealer($fromDate, $toDate, $dealer_id), 'preorders.csv');
            case 'excel':
                return Excel::download(new PreordersExportDealer($fromDate, $toDate, $dealer_id), 'preorders.xlsx');
            case 'excelinactive':
                return Excel::download(new PreordersExportDealerInactive($fromDate, $toDate, $dealer_id), 'preordersinactive.xlsx');
        }
    }

    public function general(){
        return view('admin.presaleorders.general');
    }
    public function searchGeneral(Request $request){

        $month = $request->input('month');
        $year = $request->input('year');
        $preorders = StockRequest::with(['items','dealer'=>function($query)use($month, $year){
            $query->with(['stockrequests'=>function($query)use ($month, $year){
                $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            }]);
        },'van'=>function($query)use ($month, $year){
            $query->with(['target'=>function($query)use ($month, $year){
                $query->where(['month'=>$month,'year'=>$year]);
            },'stockrequests'=>function($query)use ($month, $year){
                $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            }]);
        },'customerroute'=>function($query)use ($month, $year){
            $query->with(['customers','updated_customers'=>function($query)use ($month, $year){
                $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            },'new_customers'=>function($query)use ($month, $year){
                $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
            }]);
        },'saler','customer'])->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)->get();

        return response()->json(['preorders' => $preorders]);

    }


    public function exportPresaleGeneral(Request $request)
    {
        //dd($request->all());
        $month = $request->input('month');
        $year = $request->input('year');
        $type = $request->input('type');
        switch ($type) {
            case 'csv':
                return Excel::download(new PreordersExportGeneral($month, $year), 'preorders.csv');
            case 'excel':
                return Excel::download(new PreordersExportGeneral($month, $year), 'preorders.xlsx');
            case 'excelinactive':
                return Excel::download(new PreordersExportGeneralInactive($month, $year), 'preordersinactive.xlsx');
        }
    }


}
