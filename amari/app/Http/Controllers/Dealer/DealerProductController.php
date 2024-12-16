<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\ProductBrand;
use App\Models\Product;
use App\Models\Location;
use App\Models\LocationProduct;
use App\Models\Stock;
use App\Models\ProductVariance;
use App\Models\Supplier;
use App\Models\StockDamage;
use App\Models\StockCount;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use App\Models\EfrisSetting;
use Gate;
use App\Http\Controllers\Helper\Efris\ProductController;
use App\Http\Controllers\Helper\Efris\KeysController;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Branch;
use App\Models\Dealer;
use App\Models\Tax;
use App\Models\DealerProduct;

class DealerProductController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $dealer  = Auth::guard('dealer')->user()->dealer->code;

        $products = Product::with(['category','brand','tax','dealerproduct'=>function($query){
            return $query->where('dealer_id',Auth::guard('dealer')->user()->dealer_id);
        }])->get();
        return view('dealer.products.index',compact('products'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function updateProduct(DealerProduct $product){
        if(\Auth::guard('dealer')->check()){
      $product->update([
          'sellingprice'=>request()->sellingprice,
          'stock'=>request()->stock,
          'efris_product_code'=>request()->efris_product_code
      ]);
        return redirect()->back()->with('message', 'Product has been updated successfully!');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function create(Product $product){
        if(\Auth::guard('dealer')->check()){
            $product->load(['dealerproduct'=>function(){
                return $this->where('dealer_id',Auth::guard('dealer')->user()->dealer_id);
            }]);
            if($product->dealerproduct){
                $item = $product->dealerproduct;
                return view('dealer.products.edit',compact('categories','brands','branches','suppliers','units','taxes'));
            }else{
                return view('dealer.products.create',compact('categories','brands','branches','suppliers','units','taxes'));
            }

        }else{
            return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
        }
    }

    public function viewedit(Product $product){
        if(\Auth::guard('dealer')->check()){
            $product->load(['dealerproduct'=>function($query){
                return $query->where('dealer_id',Auth::guard('dealer')->user()->dealer_id);
            }]);

            if($product->dealerproduct !== null){
                $item = $product->dealerproduct;
                return view('dealer.products.edit',compact('item','product'));
            }else{
                return view('dealer.products.create',compact('product'));
            }

        }else{
            return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
        }
    }
    public function viewaddcount(){
        if(\Auth::guard('dealer')->check()){
        $brands = ProductBrand::all();
        $product = Product::with('locationproducts')->find(request()->product);
        $locations = Location::all();
        return view('dealer.products.addcount',compact('brands','product','locations'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function store(){
        if(\Auth::guard('dealer')->check()){
        DealerProduct::create([
            'product_id'=>request()->productid,
            'sellingprice'=>request()->sellingprice,
            'dealer_id'=>Auth::guard('dealer')->user()->dealer_id,
            'stock'=>request()->stock,
            'efris_product_code'=>request()->efris_product_code
        ]);
        return redirect()->route('products.index')->with('success', 'Product has been added successfully!');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
       // return back();
    }
    public function editProduct(){
      // dd(request()->all());
      if(\Auth::guard('dealer')->check()){
      $vnames = request()->vname;
      $vquantities = request()->vquantities;
      $vprices = request()->vprices;

        Product::find(request()->productid)->update([
            'name'=>request()->productname,
            'brand_id'=>request()->productbrandname,
            'code'=>request()->productcode,
            'stock'=>request()->productstock,
            'price'=>request()->productprice,
            'category'=>request()->categorycode,
            'efriscategoryname'=>request()->efriscategoryname,
            'efriscategorycode'=>request()->categorycode,
            'unit'=>request()->productunit,
            'supplier_id'=>request()->productsupplier,
            'product_category_id'=>request()->productcategory,
            'tax_id'=>request()->tax,
            //'location_id'=>request()->locationid,
            // 'cost'=>request()->cost,
            // 'suppvat'=>request()->cost*0.18,

        ]);


        // foreach($vnames as $key=> $a){
        //     ProductVariance::create([
        //         'name'=>$vnames[$key],
        //         'price'=>$vprices[$key],
        //         'quantity'=>$vquantities[$key],
        //         'product_id'=>$product->id,
        //     ]);
        // }

        return redirect()->back()->with('success', 'Product has been edited');
        //return back();
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function productDetails(){
        $product = Product::find(request()->product);
        return response()->json(['product'=>$product]);

    }

    public function storecount(){
        if(\Auth::guard('dealer')->check()){
       //dd(request()->all());
        $locations = request()->locations;
        $quantities = request()->quantities;
        $product = request()->productid;
        $date = request()->period;
        $damagetypes = request()->damagetype;
        $damagevalues = request()->damagevalues;
        // Stock::create([
        //     'period'=>$date,
        //     'product_id'=>$product,
        //     'amount'=>request()->amount,
        // ]);
       foreach($locations as $key=> $a){
           $location = intVal($locations[$key]);
           $quantity = intVal($quantities[$key]);
           LocationProduct::create([
               'location_id'=>$location,
               'product_id'=>$product,
               'quantity'=>$quantity,
               'countdate'=>$date,
           ]);
       }

       foreach($damagetypes  as $key=> $a){
       StockDamage::create([
        'product_id'=>$product,
        'count'=>$damagevalues[$key],
        'date'=>$date,
        'comment'=>request()->comment,
        'type'=>$damagetypes[$key]
       ]);
    }
       StockCount::create([
        'product_id'=>$product,
        'count'=>request()->amount,
        'date'=>$date,
        'comment'=>request()->comment,
    ]);

       return redirect()->back()->with('message', 'Stock Count has been saved successfully!');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
       //return back();
   }

   public function viewbatches(){
    $product = Product::with('stocks')->find(request()->product);
    //dd($product);
    return view('dealer.products.batches',compact('product'));
   }
   public function adjuststockbatch(){
    $product = Product::with('stocks')->find(request()->product);
    //dd($product);
    return view('dealer.products.adjuststock',compact('product'));
   }

   public function deletebatch(Stock $stock){
    if(\Auth::guard('dealer')->check()){
    $stock->delete();
    return back();
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
   }
   public function productcost(){
    if(\Auth::guard('dealer')->check()){
    $product = Product::with('stocks')->find(request()->product);
    return view('dealer.products.cost',compact('product'));
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
   }
   public function saveproductcost(){
    if(\Auth::guard('dealer')->check()){
    //dd(request()->all());
    $costs = request()->costs;
    $stocks = request()->stocks;
    foreach($stocks as $key => $a){
        $stock = Stock::find($stocks[$key]);
        $stock->update([
            'cost'=>$costs[$key],
        ]);
    }
    return redirect()->back()->with('success', 'Stock Costs have been saved successfully!');
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
   }
   public function savebatch(){
    if(\Auth::guard('dealer')->check()){
    //dd(request()->all());
    $batches = request()->stocks;
    $amounts = request()->amount;
    $sellingprices = request()->selling;
    foreach($batches as $key => $a){
        Stock::find($batches[$key])->update([
                'amount'=>$amounts[$key],
                'sellingprice'=>$sellingprices[$key],
        ]);
    }
    return redirect()->back()->with('success', 'Product batch has been saved.');
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
   }

   public function addbatchesview(){
    if(\Auth::guard('dealer')->check()){
    $id = request()->product;
    $product = Product::find($id);
    return view('dealer.products.addbatch',compact('product'));
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
   }
   public function saveaddbatch(){
    if(\Auth::guard('dealer')->check()){
        $dealer  = Auth::guard('dealer')->user()->dealer;

        $item = Product::find(request()->product);
        $supplier = Supplier::find($item->supplier_id);
       // dd($dealer);
        if($dealer->efris === 1 || $dealer->efris === "1"){

        $dealerefris = $dealer;
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $quantity = request()->stocks;
        $purchase_type = request()->purchase_type;
       // $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

       //$efris = (new ProductController)->addproductStock($item,$aeskey,$privatek,$tin,$deviceno,$quantity);
       $efris = (new ProductController)->restockProduct($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier,$purchase_type);

       $returncode = $efris->message['returnStateInfo']['returnCode'];
       if($returncode === "00"){
        Stock::create([
            'product_id'=>request()->product,
            'amount'=>request()->stocks,
            'sellingprice'=>request()->prices,
            'batch'=>request()->invoices,
            'cost'=>request()->cost,
            'receivedate'=>request()->receivedate,
            'expirydate'=>request()->expiry,
            'supplier_id'=>$supplier->id,
            'purchase_type'=>request()->purchase_type
        ]);
        return redirect()->back()->with('message', 'Product stock has been saved in EFRIS and Batch added successfuly.');
        //return redirect()->back()->with('success', 'Product stock has been saved in EFRIS and Batch added successfuly.');
       }else{
        return redirect()->back()->with('errors', 'Error try again.');
        //return \Redirect::back()->withErrors(['msg' => 'Error try again']);
       }
    }else{
        Stock::create([
            'product_id'=>request()->product,
            'amount'=>request()->stocks,
            'sellingprice'=>request()->prices,
            'batch'=>request()->invoices,
            'cost'=>request()->cost,
            'receivedate'=>request()->receivedate,
            'expirydate'=>request()->expiry,
            'supplier_id'=>$supplier->id,
        ]);
        return redirect()->back()->with('message', 'Product stock has been saved.');
    }
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }


   }

   public function editlocationview(){
    $product = Product::with('locationproducts','variances')->find(request()->product);
    $locations = Location::all();
    return view('dealer.products.editlocation',compact('product','locations',));
   }
   public function saveeditlocation(){
    //dd(request()->all());
    $locations = request()->locations;
    $quantities = request()->quantities;
    foreach($locations as $key=> $a){
        if($quantities[$key]){
            $locate = LocationProduct::where(['location_id'=>$locations[$key],'product_id'=>request()->productid])->first();
            if($locate){
                $locate->update([
                    'quantity'=> intVal($quantities[$key]),
                ]);
            }else{
                LocationProduct::create([
                    'location_id'=>intVal($locations[$key]),
                    'product_id'=>$product->id,
                    'quantity'=>intVal($quantities[$key]),
                ]);
            }

        }
        return redirect()->back()->with('message', 'Product locations edited successfuly');
    }
   }

   public function delete(){
    if(\Auth::guard('dealer')->check()){
    $product = Product::find(request()->product);
    $product->delete();
    return redirect()->back();
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
   }

   public function editbatch(){
    if(\Auth::guard('dealer')->check()){
    $stock = Stock::find(request()->id);
    $stock->update([
        'amount'=>request()->amount,
        'sellingprice'=>request()->sellingprice,
        'cost'=>request()->cost,
        'btach'=>request()->batch,
        'receivedate'=>request()->expirydate,
        'expirydate'=>request()->receivedate,
    ]);
    return response()->json(['message'=>'Batch edited successfuly','status'=>1]);
}else{
    return response()->json(['message'=>'Session expired please login again','status'=>0]);
    }
   }

   public function adjustbatch(){
    if(\Auth::guard('dealer')->check()){
    $stock = Stock::find(request()->id);
    $item = Product::find(request()->product);
    $quantity = request()->amount;
    $remarks = request()->remarks;
    $reason = request()->reason;
   // $stock->decrement('amount', request()->amount);
   $supplier = Supplier::find($item->supplier_id);
   $dealerefris = Dealer::find(\Auth::guard('dealer')->user()->dealer_id);
   if($dealerefris->efris === 1){

    $keypath = $dealerefris->privatekey;
    $keypwd = $dealerefris->keypwd;
    $tin = $dealerefris->tin;
    $deviceno = $dealerefris->deviceno;
   $aeskey = $dealerefris->aeskey;
    $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);

   $efris = (new ProductController)->stockReduction($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier,$remarks,$reason);


   //$efris = (new ProductController)->restockProduct($item,$aeskey,$privatek,$tin,$deviceno,$quantity);
   $returncode = $efris->message['returnStateInfo']['returnCode'];
  // dd($efris);
//    if($efris->status === 1){
    if($returncode === "00"){

        $stock->decrement('amount', request()->amount);
        return response()->json(['message'=>'Batch adjusted successfuly','status'=>1,]);
        //return redirect()->back()->with('message', 'Product stock has been saved in EFRIS add batch Added.');
       }else{
        // $item->update([
        //     'openingstock'=>1
        // ]);
        return response()->json(['message'=>'Could not send request please contact admin.','status'=>0,]);
      //  return \Redirect::back()->with('error', 'Error try again later but product stock has been saved locally.');
       }
//    }else{
//     return \Redirect::back()->withErrors(['msg' => "There is a network error try again later"]);
//    }
}else{
    $stock->decrement('amount', request()->amount);
    return response()->json(['message'=>'Batch adjusted successfuly','status'=>1,]);
   }

}else{
    return response()->json(['message'=>'Session expired please login again','status'=>0]);
    }
   }
   public function bulkEdit(Request $request){
    if(\Auth::guard('dealer')->check()){
// dd($request->all());
$ids = $request->query('ids');

    // Convert the comma-separated string to an array of IDs
    $idArray = explode(',', $ids);

    // Search for products using the array of IDs
    $products = Product::with(['dealerproduct'=>function($query){
        $query->where('dealer_id',Auth::guard('dealer')->user()->dealer_id);
    }])->whereIn('id', $idArray)->get();

    // Return the edit view with the selected products
    return view('dealer.products.edit-multiple', compact('products'));
}else{
    return redirect()->route("dealer.login.view")->with('message','Opps! You have entered invalid credentials');
}
   }
   public function bulkEditPost(Request $request){
    foreach($request->productids as $key=> $a){

        if($request->status[$key] == 1 || $request->status[$key] == '1'){
            $item = DealerProduct::find($request->dealerproductids[$key]);
            $item->sellingprice = $request->sellingprices[$key];
            $item->stock = $request->stocks[$key];
            $item->save();
        }else{
            DealerProduct::create([
                'dealer_id'=>\Auth::guard('dealer')->user()->dealer_id,
                'product_id'=>$request->productids[$key],
                'stock'=>$request->stocks[$key],
                'sellingprice'=>$request->sellingprices[$key],
                'efris_product_code'=>request()->efris_product_code
            ]);
        }
    }
    return redirect()->back()->with('message', 'Items have been created and updated successfully.');

   }
}
