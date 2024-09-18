<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper\Efris\ProductController;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\EfrisSync;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Models\EfrisSetting;
use App\Models\Supplier;


class EfrisProductController extends Controller
{
    public function syncproduct(){
        $item = Product::find(request()->product);
        $dealerefris = EfrisSetting::find(1);
        $keypath = $dealerefris->keypath;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        
       $efris = (new ProductController)->saveProduct($item,$aeskey,$privatek,$tin,$deviceno);
       $returncode = $efris->message['returnStateInfo']['returnCode'];
       if($returncode === "00"){
        $item->update([
            'sync'=> 1,
        ]);
        return redirect()->back()->with('success', 'Product has been saved in EFRIS');
       }else{
        $item->update([
            'sync'=> 1,
        ]);
        return \Redirect::back()->withErrors(['msg' => 'Already synced']);
       }
    }
    
    


    public function restock(){
        $item = Product::find(request()->stockid);
        $dealerefris = EfrisSetting::find(1);
        $keypath = $dealerefris->keypath;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $quantity = request()->stock;
       // $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

       //$efris = (new ProductController)->addproductStock($item,$aeskey,$privatek,$tin,$deviceno,$quantity);
       $efris = (new ProductController)->restockProduct($item,$aeskey,$privatek,$tin,$deviceno,$quantity);
       $returncode = $efris->message['returnStateInfo']['returnCode'];
       if($returncode === "00"){
        return redirect()->back()->with('success', 'Product stock has been saved in EFRIS');
       }else{
        return \Redirect::back()->withErrors(['msg' => 'Error try again']);
       }   
    }

    public function openingstock(){
        $item = Product::find(request()->stockid);
        $supplier = Supplier::find($item->supplier_id);
        $dealerefris = EfrisSetting::find(1);
        $keypath = $dealerefris->keypath;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
       $aeskey = $dealerefris->aeskey;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        $quantity = request()->openingstock;
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

       $efris = (new ProductController)->addproductStock($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier);
       //$efris = (new ProductController)->restockProduct($item,$aeskey,$privatek,$tin,$deviceno,$quantity);
       $returncode = $efris->message['returnStateInfo']['returnCode'];
       if($efris->status === 1){
        if($returncode === "00"){
            $item->update([
                'openingstock'=>1
            ]);
            return redirect()->back()->with('success', 'Product stock has been saved in EFRIS');
           }else{
            $item->update([
                'openingstock'=>1
            ]);
            return \Redirect::back()->withErrors(['msg' => 'Error try again']);
           }
       }else{
        return \Redirect::back()->withErrors(['msg' => "There is a network error try again later"]);
       }
      
    }
}
