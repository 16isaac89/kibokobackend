<?php
namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use App\Models\CaptainPerfomance;
use App\Models\Customer;
use App\Models\DealerUser;
use App\Models\Performance;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockRequest;
use App\Models\StockRequestProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Dealer;

class StockRequestController extends Controller
{
    public function store()
    {
        $cart     = request()->cart;
        $user     = DealerUser::find(request()->salerid);
        $customer = Customer::with('route')->find(request()->customer_id);
        $dealer   = Dealer::find($user->dealer_id);
        $stockreq = StockRequest::create([
            'van_id'         => request()->van ? request()->van : 0,
            'dealer_user_id' => request()->salerid,
            'total'          => request()->total,
            'status'         => 1,
            'requesttype'    => request()->requesttype,
            'customer_id'    => request()->customer_id,
            'dealer_id'      => $user->dealer_id,
            'checkin'        => request()->checkin,
            'checkout'       => request()->checkout,
            'route'          => $customer->route->code,
            'customer_identification'=>request()->selectedcustomeridentification
        ]);
        foreach ($cart as $key => $a) {
            $product      = Product::with('tax')->find($a['id']);
            $sellingprice = $a['dealerproduct'] ? $a['dealerproduct']['sellingprice'] : $product->selling_price;
            $quantity     = $a['quantity'];
            $net          = ($quantity * $sellingprice) - $a['discountamt'];
            $taxes        = $product->tax_amount;
            $tax          = $taxes && $taxes > 0 ? $taxes : 0;
            $taxamount    = $taxes ? match ($taxes) {
                "0.18" => floor(($tax * ($net / 1.18)) * 100) / 100,
                "18" => floor(($tax * ($net / 1.18)) * 100) / 100,
                "0" => floor((0 * (($sellingprice * $quantity) / 1.18)) * 100) / 100,
                "-" => floor((0 * (($sellingprice * $quantity) / 1.18)) * 100) / 100,
            } : 0;

            $discount       = 'fixed_value';
            $discountamount = $a['discountamt'];
            StockRequestProduct::create([
                'stock_request_id'  => $stockreq->id,
                'product_id'        => $a['id'],
                'reqqty'            => $a['quantity'],
                'appqty'            => $a['quantity'],
                'van_id'            => request()->van ? request()->van : 0,
                'dealer_product_id' => $a['dealerproduct'] ? $a['dealerproduct']['id'] : 0,
                'sellingprice'      => $sellingprice,
                'total'             => $net,
                'vat'               => $taxes,
                'vat_amount'        => $taxamount,
                'discount'          => $discountamount,
                'discounttype'      => $a['discounttype'],
            ]);
        }
        Performance::create([
            'user'      => request()->salerid,
            'points'    => 1,
            'pointtype' => 'createcustomer',
        ]);
        $cp = CaptainPerfomance::where(['dealer_id' => $user->dealer_id, 'user_id' => request()->salerid])
            ->whereDate('created_at', Carbon::today()) // Compare with today's date
            ->first();
        if ($cp) {
            $cp->increment('presale_orders', 1);
        } else {
            CaptainPerfomance::create([
                'dealer_id'      => $dealer->id,
                'user_id'        => $user -> id,
                'presale_orders' => 1,
            ]);
        }
        return response()->json(['message' => 1]);
    }

    public function reports()
    {
        $reports = Sale::with(['items', 'customer' => function ($query) {
            $query->with('route');
        }])->where('dealer_user_id', request()->id)->whereDate('created_at', request()->date)->get();
        $reportssum = $reports->sum('total');
        return response()->json(['reports' => $reports, 'sum' => $reportssum]);
    }
    public function presalereports()
    {
        $reports = StockRequest::with(['items' => function ($query) {$query->with('product');}, 'customer', 'customerroute'])->where('dealer_user_id', request()->id)
            ->whereDate('created_at', request()->date)->get();
        return response()->json(['reports' => $reports]);
    }
    public function delivery()
    {
        $deliveries = StockRequest::with(['items' => function ($query) {
            $query->with('product');
        }, 'customer'])->where(['dealer_user_id' => request()->id, 'delivered' => 0, 'status' => 2])->get();
        return response()->json(['deliveries' => $deliveries, 'id' => request()->id]);
    }
    public function customerstats(Request $request)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');

        $entries = Customer::where('dealer_code', $request->dealer)->whereDate('updated_at', $date)->get();

        return response()->json(['customers' => $entries]);
    }
}
