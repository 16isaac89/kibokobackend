<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VanProduct;
use App\Models\Product;
use App\Models\RoutePlan;
use Carbon\Carbon;
use App\Models\Dispatch;
use App\Models\RoutePlanList;
use App\Models\ProductBrand;
use App\Models\SkuTarget;
use App\Models\Van;
use App\Models\Performance;


class StockController extends Controller
{
    public function getStock(){
        $stock = VanProduct::with('dealerproduct')->where('van_id',request()->van)->get();
        //$dispatch = Dispatch::with('dispatchproducts')->where(['type'=>'van','van_id'=>request()->van])->whereDate('created_at', Carbon::today())->first();
        $dispatch = Dispatch::with('dispatchproducts')->where(['type'=>'van','van_id'=>request()->van,'dispatchdate'=>request()->date])->get()->first();
        if($dispatch){
            $dispatched = $dispatch;
        }else{
            $dispatched = Dispatch::with('dispatchproducts')->where(['type'=>'van','van_id'=>request()->van])->latest('id')->first();;
        }
        return response()->json(['dispatchid'=>$dispatched ? $dispatched->id:null,'dispatchstock'=>$dispatched ? $dispatched->dispatchproducts : null ]);
    }
    public function getBrands(){
        $brands = ProductBrand::where('dealer_id',request()->dealer)->get();
        return response()->json(['brands'=>$brands]);
    }

    public function getCustomers(){
        $id = request()->id;
        $day = request()->day;
        $week = request()->week;
        $customers="";
       // $custs = RoutePlan::with('list')->whereDate('date', Carbon::today())->where('dealer_user_id',$id)->first();
       // $custs = RoutePlan::with('list')->where('dealer_user_id',$id)->latest()->first();
       $custs = RoutePlanList::with(['customer','route'])->where(['dealer_user_id'=>$id,'week'=>$week,'day'=>$day])->get();
        if($custs){
            $customers = $custs;
        }else{
            $customers = array();
        }
        return response()->json(['customers'=>$customers,'d'=>$custs]);
    }

    public function getproducts(){
        $products = Product::with('brand')->get();
        return response()->json(['products'=>$products]);
    }
    public function getskutarget(){
        $target = array();
        $targetdets = (Object)array();
       // $sku = SkuTarget::with('items')->where([ ['fromdate', '<=', request()->date], ['todate', '>=', request()->date] ])->first();
       $sku = SkuTarget::with('items')->where('user_id',request()->id)->whereMonth('month',request()->month)->first();
        if($sku){
            $target=$sku->items;
            $targetdets = $sku;
        }
        return response()->json(['target'=>$target,'targetdets'=>$targetdets]);
    }
    public function getvan(){
        $van = Van::find(request()->id)->name;
        
        return response()->json(['van'=>$van]);
    }
}
