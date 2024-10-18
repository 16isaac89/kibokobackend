<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockRequest;
use App\Models\StockRequestProduct;
use App\Models\Sale;
use App\Models\Performance;
use App\Models\DealerUser;

class StockRequestController extends Controller
{
    public function store(){
        $cart = request()->cart;
        $user = DealerUser::find(request()->salerid);
$stockreq = StockRequest::create([
    'van_id'=>request()->van,
        'dealer_user_id'=>request()->salerid,
        'total'=>request()->total,
        'status'=>1,
        'requesttype'=>request()->requesttype,
        'customer_id'=>request()->customer_id,
        'dealer_id'=>$user->dealer_id,
        'checkin'=>request()->checkin,
        'checkout'=>request()->checkout,
        'route'=>request()->route,
]);
        foreach($cart as $key=> $a){
            $product = Product::with()->find($a['id']);
            $sellingprice = $a['dealerproduct']->sellingprice;
            $quantity = $a['quantity'];
            $net = $quantity*$sellingprice;
            $taxes = App\Models\Tax::find($item->tax_id);
            $tax = $taxes->value > 0 ? $taxes->value/100 : 0;
            $taxamount = match ($taxes->value) {
                '18' => floor(($tax*(($sellingprice*$quantity)/1.18))*100)/100,
                '0' => floor((0*(($sellingprice*$quantity)/1.18))*100)/100,
                '-' => floor((0*(($sellingprice*$quantity)/1.18))*100)/100,
            };
            StockRequestProduct::create([
                'stock_request_id'=>$stockreq->id,
                'product_id'=>$a['id'],
                'reqqty'=>$a['quantity'],
                'appqty'=>0,
                'van_id'=>request()->van,
                'dealer_product_id'=>$a['dealerproduct']->id,
                'sellingprice'=>$a['dealerproduct']->sellingprice,
                'total'=>$a['dealerproduct']->sellingprice * $a['quantity'],
                'vat'=>$product->vat,
                'vat_amount'=>$taxamount
            ]);
        }
        Performance::create([
            'user'=>request()->salerid,
            'points'=>1,
            'pointtype'=>'createcustomer',
          ]);
        return response()->json(['message'=>1]);
    }

    public function reports(){
        $reports = Sale::with(['items','customer'=>function($query){
            $query->with('route');
        }])->where('dealer_user_id',request()->id)->whereDate('created_at', request()->date)->get();
        $reportssum = $reports->sum('total');
        return response()->json(['reports'=>$reports,'sum'=>$reportssum]);
    }
    public function delivery(){
        $deliveries = StockRequest::with(['items'=>function($query){
            $query->with('product');
        },'customer'])->where(['dealer_user_id'=>request()->id,'delivered'=>0,'status'=>2])->get();
        return response()->json(['deliveries'=>$deliveries,'id'=>request()->id]);
    }
}
