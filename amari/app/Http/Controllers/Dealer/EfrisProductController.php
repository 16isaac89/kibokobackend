<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper\Efris\ProductController;
use App\Models\Dealer;
use App\Models\DealerProduct;
use App\Models\EfrisSync;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\PostdataController;
use App\Http\Controllers\Helper\Efris\InvoiceController;
use Carbon\Carbon;
use App\Models\EfrisSetting;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Supplier;

class EfrisProductController extends Controller
{
    public function syncproduct(Product $product){
         $item = $product;
         $dealerproduct = DealerProduct::where(['product_id'=>$item->id,'dealer_id'=>\Auth::guard('dealer')->user()->dealer_id])->first();
       //  dd($item);
        $dealerefris = Dealer::find(\Auth::guard('dealer')->user()->dealer_id);
        if($item->sync){
            return response()->json(['message'=>"This item has already been synced"]);
        }else{
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //dd($privatek);
        $aeskey = $dealerefris->aeskey;

       $efris = (new ProductController)->saveProduct($item,$aeskey,$privatek,$tin,$deviceno);
       //dd($efris);
       if($efris->status === "00"){
        EfrisSync::create([
            'type'=>1,
            'product_id'=>$item->id,
        ]);

        return redirect()->back()->with('message','Sync successful');
        //return response()->json(['message'=>"Sync Successfull"]);

       }else{
        return redirect()->back()->with('error','Failed to sync please try again erro '.$efris->msg);
        // return response()->json(['message'=>"Failed to sync please try again"]);
       }
    }

    }


    public function restock(Request $request){

        $item = DealerProduct::with('product')->find(1);
        $dealerproduct = DealerProduct::where(['product_id'=>$item->id,'dealer_id'=>\Auth::guard('dealer')->user()->dealer_id])->first();

        $dealer = 1;
        //$item = DealerProduct::with('product','sync')->find(request()->product);
        $dealerefris = Dealer::find($dealer);
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
       $efris = (new ProductController)->addproductStock($item,$aeskey,$privatek,$tin,$deviceno);
       if($efris->status === 0){
        return response()->json(['message'=>"Failed to restock please try again"]);
       }else if($efris->status === 1){
            EfrisSync::create([
                'type'=>1,
                'product_id'=>$item->id,
            ]);
            return response()->json(['message'=>"Restock Successfull"]);
       }
}

public function getkey(){
    $dealer = Dealer::find(request()->id);
    // foreach($dealers as $dealer){
        $keypath = $dealer->privatekey;
        $keypwd = $dealer->keypwd;
        $tin = $dealer->tin;
        $deviceno = $dealer->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

        if($aeskey){
        $dealer->aeskey = $aeskey;
        $dealer->save();
        return response()->json(['$aeskey'=>$dealer,'status'=>1,'date'=>date('Y-m-d H:i:s', strtotime($dealer->updated_at))]);
        }else{
            return response()->json(['status'=>0,'date'=>date('Y-m-d H:i:s', strtotime($dealer->updated_at))]);
        }


}

public function openingstock(){


    $item = Product::find(request()->product_id);
    $supplier = Supplier::find($item->supplier_id);

    $quantity = request()->amount;
        Stock::create([
            'product_id'=>request()->product_id,
            'amount'=>$quantity,
            'comment'=>request()->comment,
            'sellingprice'=>request()->sellingprice,
            'batch'=>request()->invnumber,
            'cost'=>request()->cost,
            'receivedate'=>request()->receive_date,
            'expirydate'=>request()->expiry_date,
            'supplier_id'=>$supplier->id
        ]);


    $dealerefris = Dealer::find(\Auth::guard('dealer')->user()->dealer_id);

if($dealerefris->efris === 1){

    $keypath = $dealerefris->privatekey;
    $keypwd = $dealerefris->keypwd;
    $tin = $dealerefris->tin;
    $deviceno = $dealerefris->deviceno;
   $aeskey = $dealerefris->aeskey;
    $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);

   $efris = (new ProductController)->addproductStock($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier);
   //$efris = (new ProductController)->restockProduct($item,$aeskey,$privatek,$tin,$deviceno,$quantity);
   $returncode = $efris->message['returnStateInfo']['returnCode'];
  // dd($efris);
//    if($efris->status === 1){
    if($returncode === "00"){

        $item->openingstock = 1;
        $item->save();
        return redirect()->back()->with('message', 'Product stock has been saved in EFRIS add batch Added.');
       }else{
        // $item->update([
        //     'openingstock'=>1
        // ]);
        return \Redirect::back()->with('error', 'Error try again later but product stock has been saved locally.');
       }
//    }else{
//     return \Redirect::back()->withErrors(['msg' => "There is a network error try again later"]);
//    }
}else{
    return redirect()->back()->with('message', 'Product stock has been saved successfully.');
   }
}



}
