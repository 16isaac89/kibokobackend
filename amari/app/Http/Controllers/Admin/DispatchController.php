<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dispatch;
use App\Models\Dealer;
use App\Models\ProductBrand;
use Auth;
use App\Models\Product;
use App\Models\DealerProduct;
use App\Models\DispatchProducts;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\TaxPayerController;
use App\Http\Controllers\Helper\Efris\ProductController;
use RealRashid\SweetAlert\Facades\Alert;

class DispatchController extends Controller
{
    public function index(){
        $dispatches = Dispatch::with('dispatchproducts')->where('type','dealer')->get();
        return view('admin.dispatch.index',compact('dispatches'));
    }
    public function create(){
       $dealers = Dealer::all();
       $brands = ProductBrand::all();
        return view('admin.dispatch.create',compact('dealers','brands'));
    }


    public function store(){
     //dd(request()->all());
      if(request()->total === " " ){
        Alert::warning('Products', 'You have not chosen any product(s).');
        return back();
      }else if(request()->dealer === "0"){
        Alert::warning('Sub Dealer', 'You have not chosen a sub dealer.');
        return back();
      }
      else{
      $possible = '1234567890';
$code = '';
$characters = mt_rand(7,14);

  $brands = request()->brands;
  $products =   request()->products;
  $units  = request()->unit;
  $prices =   request()->price;
  $totals  = request()->total;
  //$total =array_sum($totals);
  $dealer = request()->dealer;
  $dealerefris = Dealer::find($dealer);

// $keypath = $dealerefris->privatekey;
// $keypwd = $dealerefris->keypwd;
// $tin = $dealerefris->tin;
// $deviceno = $dealerefris->deviceno;
// $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
// $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
// $taxpayer = (new TaxPayerController)->getTaxPayer($deviceno,$tin,$privatek,$aeskey);



  $dispatch = Dispatch::create([
    'total'=>$total ?? 0,
    'user_id'=>Auth::user()->id,
    'count'=>count($products),
    'type'=>'dealer',
    'dealer_id'=>$dealer,
  ]);
  foreach($products as $a => $b){
    $product = Product::find($products[$a]);
    //$dproduct = DealerProduct::with('product')->where(['product_id'=>$products[$a],'dealer_id'=>$dealer])->first();

    //if($dproduct){
    //update product stock efris
    //$dproduct->increment('stock',$units[$a]);
    // if($dealerefris->efris === 1){
    // $item = $dproduct;
    // $dealerefris = Dealer::find($dealer);
    // $keypath = $dealerefris->privatekey;
    // $keypwd = $dealerefris->keypwd;
    // $tin = $dealerefris->tin;
    // $deviceno = $dealerefris->deviceno;
    // $quantity = $units[$a];
    // $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
    // $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
    // $efris = (new ProductController)->addproductStock($item,$aeskey,$privatek,$tin,$deviceno,$quantity);
    // }
   // }else{
      //send product to subd for syncing
    // DealerProduct::create([
    //     'product_id'=>$product->id,
    //     'brand_id'=>$brands[$a],
    //     'name'=>$product->name,
    //     'dealer_id'=>$dealer,
    //     'stock'=>$units[$a],
    //     'cost'=>$product->price
    // ]);
    DispatchProducts::create([
        'dispatch_id'=>$dispatch->id,
        'product_id'=>$product->id,
        'name'=>$product->name,
        'quantity'=>$units[$a],
        //'price'=>$totals[$a],
        'brand'=>$brands[$a],
    ]);
  //}

  }
return redirect()->back()->with('message', 'Items dispatched successfully to sub dealer '.$dealerefris->name);
      }

    }
    public function getItems(){
      $items = DispatchProducts::where('dispatch_id',request()->id)->get();
      return response()->json(['items'=>$items]);
    }
    public function getCopy(){
      $dealers = Dealer::all();
      $brands = ProductBrand::all();
      $items = DispatchProducts::where('dispatch_id',request()->id)->get();
      $dealer = Dispatch::find(request()->id)->dealer_id;
      $products = Product::all();
      return view('admin.dispatch.copy',compact('items','dealers','brands','products','dealer'));
    }
    public function saveCopy(){
      dd(request()->all());
    }
}
