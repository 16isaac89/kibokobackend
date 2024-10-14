<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Van;
use App\Models\Sale;
use App\Models\StockRequest;
use App\Models\Product;
use App\Models\DispatchProducts;
use App\Models\Dispatch;
use App\Models\StockRequestProduct;
use App\Models\Stock;


class StockRequestsController extends Controller
{
    public function stockreqs(){
        if(\Auth::guard('dealer')->check()){
            $dealer = Auth::guard('dealer')->user()->dealer_id;
            $vans = Van::where('dealer_id',$dealer)->get();
            $records = [];
            return view('dealer.dispatch.requests',compact('vans','records'));
           }else{
             return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
         }
    }
    public function search(){
        if(\Auth::guard('dealer')->check()){
            $dealer = Auth::guard('dealer')->user()->dealer_id;
        $records = StockRequest::with(['items'=>function($query){
            $query->with(['product']);
       },'saler','van','customer'=>function($query){
                $query->with('route');
            }])->where(['status'=>request()->status,'dealer_id'=>$dealer])->get();
        $vans = Van::where('dealer_id',$dealer)->get();
        return view('dealer.dispatch.requests',compact('vans','records'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
public function store(){
    dd(request()->all());
    $stockreq = StockRequest::find(request()->dispatchid);
    // $products = request()->product;
    // $quantity = request()->quantity;

    // $dispatch = Dispatch::create([
    //     'total'=> 0,
    //     'user_id'=>Auth::guard('dealer')->user()->id,
    //     'count'=>count($products),
    //     'type'=>'van',
    //     'dealer_id'=>Auth::guard('dealer')->user()->dealer_id,
    //     'van_id'=>$stockreq->van_id
    //   ]);

    //   foreach($stockrequestproducts as $a => $b){
    //     $item = StockRequestProduct::with('product')->find($stockrequestproducts[key]);
    //     dd($item);
    //   }

    foreach($products as $a => $b){
        $product = Product::with('brand')->find($products[$a]);
        DispatchProducts::create([
            'dispatch_id'=>$dispatch->id,
            'product_id'=>$product->id,
            'name'=>$product->name,
            'dispatchedquantity'=>$quantity[$a],
            'price'=>$product->price,
            'brand'=>$product->brand,
            'stock'=>$quantity[$a],
            'sellingprice'=>$product->price,
            'brandname'=>$product->brand->name
           // 'dealer_product_id'=>$dealerpid->id
        ]);
    StockRequestProduct::where(['product_id'=>$products[$a],'stock_request_id'=>request()->dispatchid])->first()->update([
        'appqty'=>$quantity[$a],
    ]);
    }

    $stockreq->update([
        'status'=>2
    ]);

    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $vans = Van::where('dealer_id',$dealer)->get();
    $records = [];
    return view('dealer.dispatch.requests',compact('vans','records'));
}
public function reject(){
    StockRequest::find(request()->rejectid)->update([
        "status"=> 3
    ]);
    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $vans = Van::where('dealer_id',$dealer)->get();
    $records = [];
    return view('dealer.dispatch.requests',compact('vans','records'));
}
public function viewapprove(){
    $dispatchid = request()->stockrequest;
    $stockreqs = StockRequest::find($dispatchid);
    $records = StockRequestProduct::with(['product'])->where('stock_request_id',$dispatchid)->get();
    return view('dealer.dispatch.reqapprove',compact('records','dispatchid','stockreqs'));
}
public function postapprove(){
    //dd(request()->all());
    $stockreq = StockRequest::find(request()->dispatchid);
    $stockrequestproducts = request()->stockrequestproducts;
    $batches = request()->batches;
    $gives = request()->gives;
    $discounts = request()->discounts;
    if($stockreq->requesttype === 1){
      foreach($stockrequestproducts as $a => $b){
        $item = StockRequestProduct::with(['product'=>function($query){
            $query->with('brand');
        }])->find($stockrequestproducts[$a]);
        $batch = Stock::find($batches[$a]);
        if(!$batches[$a] === '0'){

        DispatchProducts::create([
            'dispatch_id'=>$dispatch->id,
            'product_id'=>$item->product->id,
            'name'=>$item->product->name,
            'dispatchedquantity'=>$gives[$a],
            'price'=>$item->product->price,
            'brand'=>$item->product->product_brand_id,
            'stock'=>$gives[$a],
            'sellingprice'=>$batch->sellingprice ?? 0,
            'batch'=>$batches[$a],
            'brandname'=>$item->product->brand->name,
            'discount'=>$discounts,
            'sale_type'=>2
           // 'dealer_product_id'=>$dealerpid->id
        ]);
        $item->appqty = $gives[$a];
        $item->save();
        $batch->decrement('amount',$gives[$a]);
    }

      }

    $stockreq->update([
        'status'=>2
    ]);

    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $vans = Van::where('dealer_id',$dealer)->get();
    $records = [];
    return view('dealer.dispatch.requests',compact('vans','records'));


}else if($stockreq->requesttype === 2){
$dispatch = Dispatch::where('van_id',$stockreq->van_id)->latest('created_at')->first();
foreach($stockrequestproducts as $a => $b){
    $item = StockRequestProduct::with(['product'=>function($query){
        $query->with('brand');
    }])->find($stockrequestproducts[$a]);
    $batch = Stock::find($batches[$a]);

    if(!$batches[$a] === '0'){
$dispatched = DispatchProducts::where(['product_id'=>$stockrequestproducts[$a],'dispatch_id'=>$dispatch->id,'batch'=>$batches[$a]])->first();
if($dispatched){
$dispatched->increment('stock',$gives[$a]);
$item->appqty = $gives[$a];
    $item->save();
$batch->decrement('amount',$gives[$a]);
}else{
    $product = Product::find($stockrequestproducts[$a]);
    DispatchProducts::create([
        'dispatch_id'=>$dispatch->id,
        'product_id'=>$item->product->id,
        'name'=>$item->product->name,
        'dispatchedquantity'=>$gives[$a],
        'price'=>$item->product->price,
        'brand'=>$item->product->product_brand_id,
        'stock'=>$gives[$a],
        'sellingprice'=>$batch->sellingprice ?? 0,
        'batch'=>$batches[$a],
        'brandname'=>$item->product->brand->name
       // 'dealer_product_id'=>$dealerpid->id
    ]);
    $item->appqty = $gives[$a];
    $item->save();
}
}

  }
  $dealer = Auth::guard('dealer')->user()->dealer_id;
    $vans = Van::where('dealer_id',$dealer)->get();
    $records = [];
  return view('dealer.dispatch.requests',compact('vans','records'));
}else{
   // dd(request()->all());
    //$dispatch = Dispatch::where('van_id',$stockreq->van_id)->latest('created_at')->first();
    foreach($stockrequestproducts as $a => $b){
       // $product = Product::find($stockrequestproducts[$a]);
        $item = StockRequestProduct::with(['product'=>function($query){
            $query->with('brand');
        }])->find($stockrequestproducts[$a]);
        //$batch = Stock::find($batches[$a]);
       // if(!$batches[$a] === '0'){
        // DispatchProducts::create([
        //     'dispatch_id'=>$dispatch->id,
        //     'product_id'=>$item->product->id,
        //     'name'=>$item->product->name,
        //     'dispatchedquantity'=>$gives[$a],
        //     'price'=>$item->product->price,
        //     'brand'=>$item->product->product_brand_id,
        //     'stock'=>$gives[$a],
        //     'sellingprice'=>$batch->sellingprice,
        //     'batch'=>$batches[$a],
        //     'brandname'=>$item->product->brand->name
        //    // 'dealer_product_id'=>$dealerpid->id
        // ]);
    //     if(!$batches[$a] === '0'){
    //     $item->appqty = $gives[$a];
    //     $item->sellingprice = $batch->sellingprice;
    // }
    //     $item->batch_id = $batches[$a];
        // $item->discount = $discounts[$a];
        $item->appqty = $gives[$a];
        $item->save();

        //$batch->decrement('amount',$gives[$a]);
    //}

      }

    $stockreq->update([
        'status'=>2
    ]);

    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $vans = Van::where('dealer_id',$dealer)->get();
    $records = [];
    return view('dealer.dispatch.requests',compact('vans','records'));
}
}

}
