<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockRequest;
use App\Models\StockRequestProduct;
use App\Models\Sale;
use App\Models\Performance;
use App\Models\DealerUser;
use App\Models\Customer;
use App\Models\Product;

class StockRequestController extends Controller
{
    public function store(){
        $cart = request()->cart;
        $user = DealerUser::find(request()->salerid);
        $customer = Customer::with('route')->find(request()->customer_id);
$stockreq = StockRequest::create([
    'van_id'=>request()->van ? request()->van : 0,
        'dealer_user_id'=>request()->salerid,
        'total'=>request()->total,
        'status'=>1,
        'requesttype'=>request()->requesttype,
        'customer_id'=>request()->customer_id,
        'dealer_id'=>$user->dealer_id,
        'checkin'=>request()->checkin,
        'checkout'=>request()->checkout,
        'route'=>$customer->route->code,
]);
        foreach($cart as $key=> $a){
            $product = Product::with('tax')->find($a['id']);
            $sellingprice = $a['dealerproduct'] ? $a['dealerproduct']['sellingprice'] : 0;
            $quantity = $a['quantity'];
            $net = $quantity*$sellingprice;
            $taxes = $product->tax;
            $tax = $taxes && $taxes->value > 0 ? $taxes->value/100 : 0;
            $taxamount = $taxes ? match ($taxes->value) {
                '18' => floor(($tax*($net/1.18))*100)/100,
                '0' => floor((0*(($sellingprice*$quantity)/1.18))*100)/100,
                '-' => floor((0*(($sellingprice*$quantity)/1.18))*100)/100,
            } : 0;

            $discount = $a['discounttype'] == 'fixed_value' ? $a['discounttype'] : $a['discountamt']/100;
            $discountamount =  $a['discounttype'] == 'fixed_value' ? $a['discountamt'] : $net*$discount;
            StockRequestProduct::create([
                'stock_request_id'=>$stockreq->id,
                'product_id'=>$a['id'],
                'reqqty'=>$a['quantity'],
                'appqty'=>0,
                'van_id'=>request()->van ? request()->van : 0,
                'dealer_product_id'=> $a['dealerproduct'] ? $a['dealerproduct']['id'] : 0,
                'sellingprice'=>$sellingprice,
                'total'=>$net,
                'vat'=> $taxes ? $taxes->value : 0,
                'vat_amount'=>$taxamount,
                'discount'=> $discountamount,
                'discounttype'=>$a['discounttype']
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
