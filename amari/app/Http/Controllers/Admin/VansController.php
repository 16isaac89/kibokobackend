<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Van;
use App\Models\DispatchProducts;
use App\Models\DispatchCount;
use App\Models\Stock;

class VansController extends Controller
{
    public function index(){
        $vans = Van::all();
        return view('admin.vans.index',compact('vans'));
    }
    public function viewcount(){
        $van = Van::find(request()->van);
        $dispatches = [];
        return view('admin.vans.viewcount',compact('van','dispatches'));
    }
    public function search(){
        //dd(request()->all());
        $vanid = request()->van;
        $from = date(request()->fromdate);
        $to = date(request()->todate);
        $van = Van::find(request()->van);
        $dispatches = DispatchProducts::where('van_id',$vanid)->whereBetween('created_at', [$from, $to])->get();
        //dd(request()->all(),$dispatches);
        return view('admin.vans.viewcount',compact('van','dispatches'));

    }
    public function savecount(){
        //dd(request()->all());
        $dispatches = request()->dispatches;
        $van = request()->van;
        $counts = request()->counts;
        foreach($dispatches as $a => $b){
            $dispatch = DispatchProducts::find($dispatches[$a]);
            $batch = Stock::find($dispatch->batch);
            DispatchCount::create([
                'product_id'=>$dispatch->product_id,
                'dispatch_product_id'=>$dispatch->id,
                'dispatched'=>$dispatch->dispatchedquantity,
                'van_id'=>$dispatch->van_id,
                'sold'=>$dispatch->sold,
                'count'=>$counts[$a],
                'count_date'=>request()->countdate
            ]);
            if($batch){
                $batch->increment('amount',$counts[$a]);
            }
        }
        return redirect()->route('admin.vans.index');
       // dd(request()->all());
    }
}
