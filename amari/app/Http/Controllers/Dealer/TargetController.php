<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Target;
use Auth;
use App\Models\DealerUser;
use App\Models\ProductBrand;
use App\Models\SkuTarget;
use App\Models\SkuTargetProduct;
use App\Models\Stock;
use App\Models\Product;

class TargetController extends Controller
{
    public function store(){
        if(\Auth::guard('dealer')->check()){
        $dealer = Auth::guard('dealer')->user()->dealer_id;
        Target::create([
            'month'=>request()->month,
            'year'=>request()->year,
            'money'=>request()->money,
            //  'fromdate'=>request()->fromdate,
            //  'todate'=>request()->todate,
            'dealer_id'=>$dealer,
            'dealer_user_id'=>request()->user,
            'type'=>'saler',
            
        ]);
        return redirect()->back()->with('success', 'Target by month has been set successfuly.');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function storesku(){
        //dd(request()->all());
        if(\Auth::guard('dealer')->check()){
            $brands = request()->brands;
            $products =   request()->products;
            $units  = request()->unit;
            $prices =   request()->price;
            $totals  = request()->total;
            $total =array_sum($totals);
            $dealer = Auth::guard('dealer')->user()->dealer_id;
            $batches = request()->batches;
        $skutarget = SkuTarget::create([
            'user_id'=>request()->user,
            // 'fromdate'=>request()->fromdate,
            // 'todate'=>request()->todate,
            'month'=>request()->month,
            'year'=>request()->year,
        ]);
        foreach($products as $a => $b){
            $product = Product::with('brand')->find($products[$a]);
            $batch = Stock::find($batches[$a]);
            SkuTargetProduct::create([
                'sku_target_id'=>$skutarget->id,
                'product_id'=>$products[$a],
                'target_quantity'=>$units[$a],
                'selling_price'=>$prices[$a],
                'batch'=>$batches[$a],
                'product_name'=>$product->name,
                'total'=>$totals[$a],
                'user_id'=>request()->user,
                'fromdate'=>request()->fromdate,
                'todate'=>request()->todate,
            ]);
        }
        return redirect()->back()->with('success', 'Target by SKU has been set successfuly.');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! Session expired');
    }
    }


    public function create(){
        if(\Auth::guard('dealer')->check()){
        $user = DealerUser::find(request()->user);
        $brands = ProductBrand::all();
       
        return view('dealer.users.addtarget',compact('user','brands'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    
   
}
