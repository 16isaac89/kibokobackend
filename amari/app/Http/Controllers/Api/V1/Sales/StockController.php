<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Dispatch;
use App\Models\Performance;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\RoutePlan;
use App\Models\RoutePlanList;
use App\Models\SkuTarget;
use App\Models\Van;
use App\Models\VanProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DealerUser;


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
        $brands = ProductBrand::all();
        return response()->json(['brands'=>$brands]);
    }

    public function getCustomers(){
        $id = request()->id;
        $day = request()->day;
        $week = request()->week;
        $customers="";
      // $custs = RoutePlan::with('list')->whereDate('date', Carbon::today())->where('dealer_user_id',$id)->first();
       //$custs = RoutePlan::with('list')->where('dealer_user_id',$id)->latest()->first();
       $custs = RoutePlanList::with(['customer','route'])->where(['dealer_user_id'=>$id,'week'=>$week,'day'=>$day])->get();
        if($custs){
            $customers = $custs;
        }else{
            $customers = array();
        }
    //$customers = Customer::where('dealer_code',request()->dealer)->get();
        return response()->json(['customers'=>$customers]);
    }

    public function getAllCustomers(){
        $customers = Customer::where('dealer_code',request()->dealer)->get();
        return response()->json(['customers'=>$customers]);
    }


    //get all products for requests
    public function getproducts(){
        $user = DealerUser::find(request()->id);
        $user->load('productDivisions');
        $divisions = $user->productDivisions->pluck('id')->toArray();
        $dealer = Dealer::with('productDivisions')->find(request()->dealer);
        //$divisions = $dealer->productDivisions->pluck('id')->toArray();
        $products = Product::with(['brand','dealerproduct'=>function($q){
            $q->where('dealer_id',request()->dealer)->get();
        }])->where('selling_price','>',0)->whereIn('product_division_id',$divisions)->get();

        return response()->json(['products'=>$products,'dealer'=>request()->dealer]);
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
