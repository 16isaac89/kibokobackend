<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesReturnItem;
use App\Models\SaleReturn;
use App\Models\ProductBrand;
use App\Models\Location;
use App\Models\Stock;
use App\Models\Sale;
use App\Models\SaleProduct;

class ReturnsController extends Controller
{
    public function index(){
        $returns = [];
        return view('dealer.sales.returns',compact('returns'));
    }
    public function searchindex(){
        $returns = SaleReturn::with(['items','customer'])->where('status',request()->status)->get();
        return view('dealer.sales.returns',compact('returns'));
    }
    public function getreturn(){
        $brands = ProductBrand::all();
        $return = SaleReturn::with(['items'=>function($query){
            $query->with('product');
        },'customer'])->find(request()->return);
        //dd($return);
        $locations = Location::all();
        return view('dealer.sales.appreturns',compact('return','brands','locations'));
    }
    public function savereturn(){

        if(\Auth::guard('dealer')->check()){
        $salesreturn = SaleReturn::find(request()->return);
        $salesreturn->update([
            'status'=>'approved'
        ]);
        $receipt = Sale::find($salesreturn->sale_id);
        $returns = request()->returns;
        $units = request()->unit;
        $approveds = request()->approved;
        $total = array();
        foreach($returns as $a =>$b){
            $item = SalesReturnItem::with('product')->find($returns[$a]);

            $saleproduct = SaleProduct::find($item->sales_product_id);
            $price = $saleproduct->sellingprice;
            $quantity = $saleproduct->quantity-$approveds[$a];


            $batch = Stock::find($item->batch);
            $item->approved_qty = $approveds[$a];
            $item->status = 'approved';
            $item->save();
            $batch->increment('amount',$approveds[$a]);

            $saleproduct->increment('deduction',$approveds[$a]);
            $saleproduct->decrement('quantity',$approveds[$a]);

            $finalprice = $price*$quantity;
            $saleproduct->total = $finalprice;
            $saleproduct->save;
            array_push($total,$finalprice);


        }
        //dd($total);
        $returns = [];
        $receipt->total = array_sum($total);
        $receipt->save();

        return view('dealer.sales.returns',compact('returns'))->with('success', 'Return has been approved.');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function saveadminreturn(){
       // dd(request()->all());
        if(\Auth::guard('dealer')->check()){


            $total = array();
        $receipt = Sale::find(request()->receipt);

        if($receipt->type === '0'){
        $salereturn = SaleReturn::create([
            'type'=>'credit',
            'status'=>"approved",
            'van_id'=>$receipt->van_id,
            'customer_id'=>$receipt->customer_id,
            'sale_id'=>$receipt->id,
        ]);
        $returns = request()->returns;
        $units = request()->unit;
        $approveds = request()->approved;
        foreach($returns as $a =>$b){
            $item = SaleProduct::find($returns[$a]);
            $batch = Stock::find($item->batch);

            $price = $item->sellingprice;
            $quantity = $item->quantity-$approveds[$a];

            SalesReturnItem::create([
                'product_id'=>$item->product_id,
                'sales_product_id'=>$item->id,
                'qty_returned'=>0,
                'van_id'=>$item->van,
                'total_returned'=>$item->sellingprice*$approveds[$a],
                'return_tax'=>($item->sellingprice*$approveds[$a])*0.18,
                'batch'=>$item->batch,
                'receipt'=>$receipt->id,
                'status'=>"approved",
                'return_id'=>$salereturn->id,
                'approved_qty'=>$approveds[$a],
                'customer_id'=>$receipt->customer_id,
            ]);
            $batch->increment('amount',$approveds[$a]);
            $item->increment('deduction',$approveds[$a]);
            $item->decrement('quantity',$approveds[$a]);

            $finalprice = $price*$quantity;
            $item->total = $finalprice;
            $item->save;
            array_push($total,$finalprice);
        }
        $receipt->total = array_sum($total);
        $receipt->save();
        $returns = [];

        return view('dealer.sales.returns',compact('returns'))->with('success', 'Return has been approved.');
    }else{
        //do the credit note
    }
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }


public function addreturnview(){

    $brands = ProductBrand::all();
    $return = Sale::with(['items'=>function($query){
        $query->with('product');
    },'customer'=>function($query){
        $query->with('route');
    }])->find(request()->receipt);
    //dd($return);
    if($return === null){
        return redirect()->back()->with('errors', 'Receipt does not exist.');
    }else{
    $locations = Location::all();
    return view('dealer.sales.addreturn',compact('return','brands','locations'));
    }
}
}
