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
}
