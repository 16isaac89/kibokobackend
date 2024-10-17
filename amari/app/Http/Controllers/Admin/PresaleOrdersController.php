<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\StockRequest;

class PresaleOrdersController extends Controller
{
    public function index()
    {
        $dealers = Dealer::all();
        return view('admin.presaleorders.index', compact('dealers'));
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
        $query = StockRequest::query();

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('invoice_date', [$request->from_date, $request->to_date]);
        }

        $preorders = $query->get();

        return view('admin.presaleorders.search', compact('preorders'));
    }
    public function exportPresale(Request $request, $type)
    {
        dd($request->all());
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        switch ($type) {
            case 'csv':
                return Excel::download(new PreordersExport, 'preorders.csv');
            case 'excel':
                return Excel::download(new PreordersExport, 'preorders.xlsx');
            case 'pdf':
                $preorders = Preorder::all();
                $pdf = PDF::loadView('preorders.pdf', compact('preorders'));
                return $pdf->download('preorders.pdf');
        }
    }
}
