<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dispatch;
use Auth;
use App\Models\ProductBrand;
use App\Models\Dealer;
use App\Models\Van;
use App\Models\DealerProduct;
use App\Models\DispatchProducts;
use App\Models\VanProduct;
use App\Models\Product;
use App\Models\Refill;
Use Alert;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\DispatchCount;

class DispatchController extends Controller
{
   public function index(){
    if(\Auth::guard('dealer')->check()){
	   $dealer = Auth::guard('dealer')->user()->dealer_id;
	   $dispatches = Dispatch::where(['type'=>'van','dealer_id'=>$dealer])->get();
	   return view('dealer.dispatch.index',compact('dispatches'));
    }else{
      return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
  }
   }

   public function create(){
    if(\Auth::guard('dealer')->check()){
	   $dealer = Auth::guard('dealer')->user()->dealer_id;
	   $vans = Van::where('dealer_id',$dealer)->get();
       $brands = ProductBrand::all();

	   return view('dealer.dispatch.create',compact('brands','vans'));
    }else{
      return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
  }
   }

    public function productDetails(){
       // $product = DealerProduct::find(request()->product);
       $product = Product::find(request()->product);
        return response()->json(['product'=>$product]);

    }

	public function brandProducts(){
		//$dealer = Auth::guard('dealer')->user()->dealer_id;
    //$products = DealerProduct::where(['brand_id'=>request()->brand,'dealer_id'=>$dealer])->get();
    $products = Product::with(['dealerproduct'=>function($query){
        $query->where('dealer_id',Auth::guard('dealer')->user()->dealer_id);
    }])->where(['brand_id'=>request()->brand])->get();
    return response()->json(['products'=>$products]);

   }
   public function store(){
    //dd(request()->all());
    if(\Auth::guard('dealer')->check()){
        $dealer = Auth::guard('dealer')->user()->dealer_id;
        $branch = Auth::guard('dealer')->user()->branch_id;
      $dispatch = Dispatch::where('van_id',request()->van)->where('dispatchdate',request()->dispatchdate)->where('dealer_id',$dealer)->get();

      if(count($dispatch) > 0 ){return \Redirect::back()->withErrors(['msg' => 'You have already dispatched to this van today, please use the refill action']);

       // Alert::warning('Duplicate', 'You have already dispatched to this van today, please use the refill action');
       // return back();
      }else{

  $brands = request()->brands;
  $products =   request()->products;
  $units  = request()->unit;
  $prices =   request()->price;

  $totals  = request()->total;
  $total =array_sum($totals);
  $dealer = Auth::guard('dealer')->user()->dealer_id;
  $batches = request()->batches;

  if($products){
    $dispatch = Dispatch::create([
      'total'=>$total,
      'user_id'=>Auth::guard('dealer')->user()->id,
      'count'=>count($products),
      'type'=>'van',
      'dealer_id'=>$dealer,
      'van_id'=>request()->van,
      'branch_id'=>$branch,
      'dispatchdate'=>request()->dispatchdate,
      'sale_type'=>1
    ]);
  }else{
    return \Redirect::back()->with('error', 'You have not chosen any product for your dispatch.');
  }

  foreach($products as $a => $b){
    $product = Product::with(['brand','dealerproduct'=>function($query){
        $query->where('dealer_id',Auth::guard('dealer')->user()->dealer_id);
    }])->find($products[$a]);
   // $batch = Stock::find($batches[$a]);
    if($products[$a] === 'Select Product'){
      continue;
    }else{
      DispatchProducts::create([
        'dispatch_id'=>$dispatch->id,
        'product_id'=>$product->id,
        'dealer_product_id'=>$product->dealerproduct->id,
        'name'=>$product->name,
        'dispatchedquantity'=>$units[$a],
        'price'=>$totals[$a],
        'brand'=>$brands[$a],
        'stock'=>$units[$a],
        'sellingprice'=>$prices[$a],
        'brandname'=>$product->brand->name,
        'batch'=>$product->dealerproduct->stock,
        'van_id'=>request()->van,
        'sale_type'=>1
       // 'dealer_product_id'=>$dealerpid->id

    ]);
    $product->dealerproduct->decrement('stock',$units[$a]);
    }
   }
   $dispatches = Dispatch::where(['type'=>'van','dealer_id'=>$dealer])->get();
   return \Redirect::back()->with('message', 'Hooray, You have successfully made a dispatch.');
   //return view('dealer.dispatch.index',compact('dispatches'));
  }
  }else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
}

public function records(){
  if(\Auth::guard('dealer')->check()){
    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $branch = Auth::guard('dealer')->user()->branch_id;
    $vans = Van::where('dealer_id',$dealer)->get();
    $records = [];
    return view('dealer.dispatch.records',compact('vans','records'));
   }else{
     return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
 }
}

public function getvanrecords(Request $request){
    // $validatedData = $request->validate([
    //     'van' => 'required|exists:vans,id',
    //     'from_date' => 'required|date',
    //     'to_date' => 'required|date|after_or_equal:from_date',
    // ]);
   // dd($request->all());

    $records = Dispatch::with('dispatchproducts')
        ->where('van_id', $request->van)
        ->where('type', 'van')
        ->whereBetween('dispatchdate', [$request->from_date, $request->to_date])
        ->get();
       // dd($records);

    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $vans = Van::where('dealer_id', $dealer)->get();
    return view('dealer.dispatch.records',compact('vans','records'));
    // return view([
    //     'vans' => $vans,
    //     'records' => $records,
    //     'from_date' => $request->from_date,
    //     'to_date' => $request->to_date,
    //     'van_id' => $request->van,
    // ]);
}


public function savecount(){
  $products = request()->product;
  $quantity = request()->quantity;
  foreach($products as $a => $b){
    $dispatchproduct = DispatchProducts::find($products[$a]);
    $dispatchproduct->update([
      'count'=>$quantity[$a],
    ]);

  }
  return redirect()->route('dealer.dispatch.records');
  //return back();
}

public function refill(){
  $products = DispatchProducts::where('dispatch_id',request()->id)->get();
  $van = Dispatch::find(request()->id)->van_id;
  return response()->json(['products'=>$products,'van'=>$van]);
}
public function saverefill(){
  //dd(request()->dispatchvanid);
  $product =   request()->product;
  $quantity =   request()->quantity;
  $van = request()->dispatchvanid;
  $dispatch = Dispatch::find(request()->dispatch_id);

  foreach($product as $a => $b){
    $dispatchproduct = DispatchProducts::find($product[$a]);
    $batch = Stock::find($dispatchproduct->batch);
    Refill::create(
      [
        'beforeqty'=>$dispatchproduct->quantity,
        'refill'=>$quantity[$a],
        'dispatch_product_id'=>$dispatchproduct->id,
        'dispatch_id'=>request()->dispatch_id,
       'van_id'=>request()->dispatchvanid
      ]
      );
    $dispatchproduct->increment('stock',$quantity[$a]);
    $dispatchproduct->increment('dispatchedquantity',$quantity[$a]);
    if($batch){
      $batch->decrement('amount',$quantity[$a]);
    }

  }
  return redirect()->route('dealer.dispatch.records');
}

public function viewtopup(){

  $dispatch = Dispatch::with(['dispatchproducts'=>function($query){
      $query->with('batchstock');
  }
  ,'van','dealer','user'])->find(request()->dispatch);
  //dd($dispatch);
  $brands = ProductBrand::all();
  return view('dealer.dispatch.add',compact('dispatch','brands'));
}

public function topupstore(){
  $dispatch = Dispatch::find(request()->dispatch);

  $brands = request()->brands;
  $products =   request()->products;
  $units  = request()->unit;
  $prices =   request()->price;
  $totals  = request()->total;
  $total =array_sum($totals);
  $dealer = Auth::guard('dealer')->user()->dealer_id;
  $branch = Auth::guard('dealer')->user()->branch_id;
  $dispatch->increment('total',$total);
  $batches = request()->batches;

  foreach($products as $a => $b){
    $product = Product::with('brand')->find($products[$a]);
    $dispatchproduct = DispatchProducts::where(['dispatch_id'=>$dispatch->id,'product_id'=>$products[$a]])->first();

    // if ($dispatchproduct === null) {
      DispatchProducts::create([
        'dispatch_id'=>$dispatch->id,
        'product_id'=>$product->id,
        'name'=>$product->name,
        'dispatchedquantity'=>$units[$a],
        'price'=>$totals[$a],
        'brand'=>$brands[$a],
        'stock'=>$units[$a],
        'sellingprice'=>$prices[$a],
        'batch'=>$batches[$a],
        'brandname'=>$product->brand->name,
        'van_id'=>request()->vanid
       // 'dealer_product_id'=>$dealerpid->id
    ]);
  //  }else{
  //   Refill::create(
  //     [
  //       'beforeqty'=>$dispatchproduct->quantity,
  //       'refill'=>$units[$a],
  //       'dispatch_product_id'=>$dispatchproduct->id,
  //       'dispatch_id'=>$dispatch->id,
  //       // 'van_product'=>$vanp->id,
  //      'van_id'=>$dispatch->van_id
  //     ]
  //     );
  //   $dispatchproduct->increment('stock',$units[$a]);
  //  }


   }
   $dispatches = Dispatch::where('branch_id',$branch)->get();
   return view('dealer.dispatch.index',compact('dispatches'));
}

public function productBatch(){
  $batches = Stock::where('product_id',request()->product)->where('amount','>','0')->get();
  return response()->json(['batches'=>$batches]);
}
public function batchPrice(){
  $batch = Stock::find(request()->batch);
  return response()->json(['batch'=>$batch]);
}
public function searchdispatch(Dispatch $dispatch){
    if(\Auth::guard('dealer')->check()){
  $dispatch->load(['dispatchproducts'=>function($query){
    $query->with('dispatchcount');
  },'van','dispatchcounts']);
  //dd($dispatch);
  $dispatchcount = count($dispatch->dispatchcounts);
  $dispatches = $dispatch->dispatchproducts;
  $van =  $dispatch->van;
  $van_id = $dispatch->van->id;
  $dispatch = $dispatch->id;
  return view('dealer.dispatch.count',compact('dispatches','van','van_id','dispatch','dispatchcount'));
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}

}
public function savedispatchcount(){
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
          'van_id'=>request()->van,
          'sold'=>$dispatch->sold,
          'count'=>$counts[$a],
          'count_date'=>request()->countdate,
          'dispatch_id'=>request()->dispatch,
          'dealer_id'=>Auth::guard('dealer')->user()->dealer_id,
        'branch_id'=> Auth::guard('dealer')->user()->branch_id
      ]);
      if($batch){
          $batch->increment('amount',$counts[$a]);
      }
  }
  return redirect()->back()->with('message','Count for date '.request()->countdate.' Has been saved successfully.');
  //return redirect()->route('admin.vans.index');
 // dd(request()->all());
}


public function getItems(){
    $items = DispatchProducts::where('dispatch_id',request()->id)->get();
    return response()->json(['items'=>$items]);
  }

  public function dealerDispatch(){
    $records = [];
    return view('dealer.dispatch.dealerdispatch')->with(['records'=>$records]);
  }
  public function dealergetDispatch(Request $request){
    $from_date = $request->from_date;
    $to_date = $request->to_date;

    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $records = Dispatch::where(['dealer_id'=>$dealer,'type'=>'dealer','status'=>$request->status])
    ->whereBetween('created_at',[$from_date,$to_date])->get();
    //dd($records);
    return redirect()->route('dealer.dispatch.maindealer')->with([
        'records' => $records,
        'from_date' => $from_date,
        'to_date' => $to_date,
    ]);
  }
  public function dealerDispatched(Dispatch $dispatch){
    $dispatch->load(['dispatchproducts'=>function($query){
        $query->with(['product'=>function($query){
            $query->with('brand');
        }]);
    }]);

    return view('dealer.dispatch.dealerdispatchitems',compact('dispatch'));
  }
  public function updatedispatched(Request $request){
//     "dispatchproductids" => array:4 [▼
//     0 => "18"
//     1 => "19"
//     2 => "20"
//     3 => "21"
//   ]
//   "receiveds" => array:4 [▼
//     0 => "100"
//     1 => "300"
//     2 => "600"
//     3 => "400"
//   ]
Dispatch::find($request->dispatchid)->update(['status'=>1]);
    $dispatchproductids = request()->dispatchproductids;
    $receiveds = request()->receiveds;
    foreach($dispatchproductids as $a => $b){

        $dispatchproduct = DispatchProducts::find($dispatchproductids[$a]);
        //$dispatchproduct->increment('received',$receiveds[$a]);
        //dd($dispatchproductids[$a],$dispatchproduct,$receiveds[$a]);
        $dispatchproduct->	received = $receiveds[$a];
        $dispatchproduct->save();

       // dd($dispatchproduct);
    }

return redirect()->back()->with('message','Dispatch has been updated successfully.');
  }

}
