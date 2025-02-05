<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\Efris\InvoiceController;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\DealerUser;
use App\Models\Dispatch;
use App\Models\DispatchProducts;
use App\Models\EfrisDocument;
use App\Models\EfrisSetting;
use App\Models\Performance;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\SaleReturn;
use App\Models\SalesReturnItem;
use App\Models\SkuTargetProduct;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Tax;
use App\Models\DealerProduct;
use App\Models\EfrisFailedJob;

class OrderController extends Controller
{
    public function store()
    {
        $dealer = request()->dealer;
        $branch = request()->branch;
        $customer = request()->customer;
        $salerid = request()->salerid;
        $cart = request()->cart;
        $van = request()->van;
        $route = Customer::where('identification', $customer)->first();
        $saler = DealerUser::find($salerid)->username;
        $total = request()->total;
        $dealerefris = Dealer::find($dealer);

        $lock = Cache::lock('saveorder', 10);

        if ($lock->get()) {
            $sale = Sale::create([
                'dealer_user_id' => $salerid,
                'route_id' => $route->route_id ,
                'van_id' => $van,
                'dealer_id' => $dealer,
                'total' => $total,
                'customer_id' => $customer,
                'type' => 1,
                'latitude' => request()->latitude,
                'longitude' => request()->longitude,
                'vat' => 0.18 * $total,
                'saleidentification' => request()->saleidentification,
                'datecreated' => request()->datetime,
                'dealer_id' => $dealer,
                'branch_id' => $branch,
                'checkin'=>request()->checkin,
                'checkout'=>request()->checkout,
            ]);
            foreach ($cart as $key => $a) {
               // Product::find($a['product_id'])->decrement('stock', intval($a['quantity']));
                $product = Product::find($a['product_id']);
                // if (DealerUser::find($salerid)->targettype === 'sku') {
                //     $sku = SkuTargetProduct::where(['product_id' => $a['product_id'], 'user_id' => $salerid])->whereDate('fromdate', '>=', request()->date)
                //         ->whereDate('todate', '<=', request()->date)->first();
                //     if ($sku) {
                //         $sku->increment('sold', $a['quantity']);
                //     }

                // }
                // $hsvat = (0.18 / 118) * $product->price;
                $dispatchp = DispatchProducts::find($a['id']);

                'sale_id' => $sale->id,

                SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $a['product_id'],
                    // 'name' => $a['name'],
                    'quantity' => $a['quantity'],
                    'qtybefore' => $a['quantity'],
                    'total' => intval($a['quantity']) * $a['sellingprice'] - $a['discount'],
                    'withoutdiscount' => intval($a['quantity']) * $a['sellingprice'],
                    'sellingprice' => $a['sellingprice'],
                    'totalcost' => $product->cost * $a['quantity'],
                    // 'hosanavat' => $hsvat * $a['quantity'],
                    'customer' => $customer,
                    'van' => $van,
                    // 'product_variance_id'=>$a['variance'],
                    'route_id' => $route->route_id,
                    'discount' => $a['discount'],
                    'batch' => $a['batch'],
                    'product_brand_id' => $product->brand_id,
                    // 'sale_type' => $a['sale_type'],
                ]);
                // if (request()->deliveryorder === "0" || request()->deliveryorder === 0) {
                    $dispatchp->increment('sold', $a['quantity']);
                    $dispatchp->decrement('stock', $a['quantity']);
                // }
            }

            $goodsdetails = array();
            foreach ($cart as $key => $a) {
                $item = Product::with('dealerproduct')->find($a['product_id']);
                $gooddetails = (Object) [
                    "item" => $item->name,
                    // "itemCode" => $item->dealerproduct->efris_product_code ? $item->dealerproduct->efris_product_code : $item->code,
                    "itemCode" => $item->code,
                    'goodsCategoryId' => $item->category ?? '',
                    "qty" => $a['quantity'],
                    "unitOfMeasure" => $item->unit ?? '',
                    "unitPrice" => $item->selling_price,
                    "total" => $item->selling_price * $a['quantity'] - $a['discount'],
                    'discount' => $a['discount'],
                    "id"=>$a['product_id']
                ];
                array_push($goodsdetails, $gooddetails);
            }
            //$dispatch = Dispatch::with('dispatchproducts')->where(['type'=>'van','van_id'=>$van])->first();
          $dispatch = Dispatch::with('dispatchproducts')->where(['type' => 'van', 'van_id' => $van])->latest()->first();
            // if (request()->deliveryorder === "1" || request()->deliveryorder === 1) {
            //     StockRequest::find(request()->deliveryorderid)->update([
            //         'delivered' => 1,
            //     ]);
            // }
            //$stock = VanProduct::with('dealerproduct')->where('van_id',request()->van)->get();
            return response()->json([
                'message' => 200,
                'number' => $sale->id,
                'total' => $total,
                'saler' => $saler,
                'customer' => $route,
                'dealer' => $dealerefris,
                'items' => $goodsdetails,
                'created' => $sale->created_at,
                'dispatchstock' => $dispatch ? $dispatch->dispatchproducts : [],
                "customertype" => request()->customertype,
                'efris' => 0,
            ]);
        }

    }

    public function saveinvoice()
    {

        $dealer = request()->dealer;
        $branch = request()->branch;
        $customer = request()->customer;
        $salerid = request()->salerid;
        $cart = request()->cart;
        $van = request()->van;
        $route = Customer::where('identification', $customer)->first();
        $saler = DealerUser::find($salerid)->username;
        $total = request()->total;
        $dealerinfo = Dealer::find($dealer);
        $sale = Sale::create([
            'dealer_user_id' => $salerid,
            'route_id' => $route->route_id,
            'van_id' => $van,
            'dealer_id' => $dealer,
            'total' => $total,
            'customer_id' => $customer,
            'type' => 1,
            'latitude' => request()->latitude,
            'longitude' => request()->longitude,
            'saleidentification' => request()->saleidentification,
            'dealer_id' => $dealer,
            'branch_id' => $branch,
            'checkin'=>request()->checkin,
            'checkout'=>request()->checkout,
        ]);
        $customerdetails = Customer::where('identification', $customer)->first();

        $dealerefris = Dealer::find($dealer);
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath, $keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;

        $goodsdetailss = array();
        $taxDetails = array();
        $ordernumber = 0;
        $itemcount = count($cart);

        $saleid = $sale->id;
        // return response()->json(['gds'=>$itemcount]);
        foreach ($cart as $key => $a) {
            $item = Product::find($a['product_id']);
            $taxes = Tax::find($item->tax_id);

                $tax = $taxes->value > 0 ? intval($taxes->value)/100 : 0;



            $net = intval($a['quantity']) * $a['sellingprice'];
            $netamt = $net - $net * 0.18;
            $taxamm = $net * 0.18;
            $gooddetails = "";
            $discountdetails = "";


            //$taxamount = floor(($tax*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100;
            $taxamountdisc = floor(($tax*($a['discount']/1.18))*100)/100;


            $taxcategorycode = match ($taxes->value) {
                '18' => '01',
                '0' => '02',
                '-' => '03',
            };
            $taxrate = match ($taxes->value) {
                '18' => 0.18,
                '0' => '0',
                '-' => '-',
            };
            $taxamount = match ($taxes->value) {
                '18' => floor(($tax*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,
                '0' => floor((0*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,
                '-' => floor((0*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,
            };

            if ($a['discount'] > 0) {
                $gooddetails = (Object) [
                    "item" => $item->name,
                    "itemCode" => $item->code,
                    'goodsCategoryId' => $item->efriscategorycode,
                    "qty" => $a['quantity'],
                    "unitOfMeasure" => $item->unit,
                    "unitPrice" => $a['sellingprice'],
                    "total" => $a['sellingprice'] * $a['quantity'],

                    "taxRate"=>$taxrate,
                    "tax"=>$taxamount,
                    // "taxRate"=> $taxes->value > 0 ? $taxes->value/100 : '0',
                    // "tax"=> $taxes->value > 0 ? $taxamount : '0',
                    //LINE FOR DISCOUNT
                    "discountTotal" => -$a['discount'],
                    "discountTaxRate" => "",
                    "orderNumber" => $ordernumber++,
                    "discountFlag" => "1",
                    "deemedFlag" => "2",
                    "exciseFlag" => "2",
                    "categoryId" => "1234",
                    "categoryName" => "Test",
                    "commodityCategoryId" => $item->efriscategorycode,
                    "goodsCategoryName" => "Test",
                    "exciseRate" => "",
                    "exciseRule" => "1",
                    "exciseTax" => "",
                    "pack" => "1",
                    "stick" => "20",
                    "exciseCurrency" => "UGX",
                    "exciseRateName" => "123",
                    "vatApplicableFlag"=>"1"
                ];
                $discountdetails = (Object) [
                    "item" => $item->name . " (Discount)",
                    "itemCode" => $item->code,
                   'goodsCategoryId' => $item->efriscategorycode,
                    "qty" => "",
                    "unitOfMeasure" => $item->unit,
                    "unitPrice" => "",

                    "total" => -$a['discount'],
                    "taxRate"=>$taxrate,
                    "tax"=>-$taxamountdisc,
                    //LINE FOR DISCOUNT
                    "discountTotal" => "",
                    "discountTaxRate" => "",
                    "orderNumber" => $ordernumber++,
                    "discountFlag" => "0",
                    "deemedFlag" => "2",
                    "exciseFlag" => "2",
                    "categoryId" => "1234",
                    "categoryName" => "Test",
                    "commodityCategoryId" => $item->efriscategorycode,
                    "goodsCategoryName" => "Test",
                    "exciseRate" => "",
                    "exciseRule" => "1",
                    "exciseTax" => "",
                    "pack" => "1",
                    "stick" => "20",
                    "exciseCurrency" => "UGX",
                    "exciseRateName" => "123",
                ];
                $taxDetail = (Object) [
                    "taxCategoryCode"=> $taxcategorycode,
                    "taxCategory" => "Standard",
                    "taxRateName" => "VAT-Standard",

                    "netAmount"=>$tax > 0 ? floor((($a['quantity']*$a['sellingprice'])/1.18 + 0.18*(($a['sellingprice']*$a['quantity'])/1.18)-floor((0.18*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100)*100)/100 : floor((($a['quantity']*$a['sellingprice'])/1.18 + 0.18*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,
                    //'netAmount'=>5*$sellingprice,
                    "taxRate"=>$taxrate,
                    "taxAmount"=>$taxamount,
                    //"taxAmount"=>"0",
                    //"grossAmount"=>  floor((($a['quantity']*$a['sellingprice'])/1.18 + 0.18*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,
                    //"taxAmount"=>"0",
                    //"grossAmount"=>  $a['quantity']*$a['sellingprice'],
                    //"grossAmount" => $a['sellingprice'] * $a['quantity'] - $a['discount'],
                    "grossAmount"=>  floor((($a['quantity']*$a['sellingprice'])/1.18 + 0.18*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,


                    // "netAmount" => $a['sellingprice'] * $a['quantity'] - $net * 0.18,
                    // "taxRate" => "0.18",
                    // "taxAmount" => $a['sellingprice'] * 0.18 * $a['quantity'],
                    // "grossAmount" => $a['sellingprice'] * $a['quantity'],
                    "exciseUnit"=> "101",
                    "exciseCurrency" => "UGX",
                    "taxRateName" => "123",
                ];
            } else {
                $gooddetails = (Object) [
                    "item" => $item->name,
                    "itemCode" => $item->code,
                    'goodsCategoryId' => $item->efriscategorycode,
                    "qty" => $a['quantity'],
                    "unitOfMeasure" => $item->unit,
                    "unitPrice" => $a['sellingprice'],
                    "total" => $a['sellingprice'] * $a['quantity'],
                    //"taxCategoryCode" => $tax > 0 ? "01":"02",
                    //"taxCategory" => "Standard",
                    "taxRate"=>$taxrate,
                    "tax"=>$taxamount,
                    //LINE FOR DISCOUNT
                    "discountTotal" => "",
                    "discountTaxRate" => "",
                    "orderNumber" => $ordernumber++,
                    "discountFlag" => "2",
                    "deemedFlag" => "2",
                    "exciseFlag" => "2",
                    "categoryId" => "1234",
                    "categoryName" => "Test",
                    "commodityCategoryId" => $item->efriscategorycode,
                    "goodsCategoryName" => "Test",
                    "exciseRate" => "",
                    "exciseRule" => "1",
                    "exciseTax" => "",
                    "pack" => "1",
                    "stick" => "20",
                    "exciseCurrency" => "UGX",
                    "exciseRateName" => "123",
                    "vatApplicableFlag"=>"1"
                ];
                $taxDetail = (Object) [
                    "taxCategoryCode"=> $taxcategorycode,
                    "taxCategory" => "Standard",
                    "taxRateName" => "VAT-Standard",

                    "netAmount"=>$tax > 0 ? floor((($a['quantity']*$a['sellingprice'])/1.18 + 0.18*(($a['sellingprice']*$a['quantity'])/1.18)-floor((0.18*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100)*100)/100 : floor((($a['quantity']*$a['sellingprice'])/1.18 + 0.18*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,
                    //'netAmount'=>5*$sellingprice,
                    "taxRate"=>$taxrate,
                    "taxAmount"=>$taxamount,
                    //"taxAmount"=>"0",
                    "grossAmount"=>  floor((($a['quantity']*$a['sellingprice'])/1.18 + 0.18*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,



                    // "netAmount" => $a['sellingprice'] * $a['quantity'] - $net * 0.18,
                    // "taxRate" => "0.18",
                    // "taxAmount" => $a['sellingprice'] * 0.18 * $a['quantity'],
                    // "grossAmount" => $a['sellingprice'] * $a['quantity'],
                    "exciseUnit"=> "101",
                    "exciseCurrency" => "UGX",
                    "taxRateName" => "123",
                ];
            }

            array_push($goodsdetailss, $gooddetails, $discountdetails);
            array_push($taxDetails, $taxDetail);
        }
        $removedups = array_unique($goodsdetailss, SORT_REGULAR);
        $goodsdetails = array_values(array_filter($removedups));
        //$goodsdetails = array_values(array_filter($goodsdetailss));
        $sumgross = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->grossAmount)) {
                $sumgross += $value->grossAmount;
            }

        }
        $summarytotal = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->netAmount)) {
                $summarytotal += $value->netAmount;
            }

        }

        $taxamount = 0;
        foreach ($taxDetails as $key => $value) {
            if (isset($value->taxAmount)) {
                $taxamount += $value->taxAmount;
            }

        }
        //return response()->json(['gds'=>$taxDetails]);

        $efris = (new InvoiceController)->saveInvoice($aeskey, $privatek, $tin, $deviceno, $goodsdetails, $taxDetails, $saleid, $total, $itemcount, $route, $dealerefris, $sumgross, $summarytotal, $taxamount, $customerdetails);
        //return response()->json(['gds'=>$efris]);

        // return response()->json(['asffadfas'=>'asdasdasdasdasd','responsecodeed'=>$efris->respcode['returnStateInfo']['returnCode']]);
        if ($efris->status === 200) {
            if ($efris->respcode['returnStateInfo']['returnCode'] === "00") {
                EfrisDocument::create([
                    "fdn" => $efris->data->basicInformation->invoiceNo,
                    "invoiceid" => $efris->data->basicInformation->antifakeCode,
                    "invoiceindustrycode" => $efris->data->basicInformation->invoiceIndustryCode,
                    "invoicekind" => $efris->data->basicInformation->invoiceKind,
                    "invoiceno" => $efris->data->basicInformation->invoiceNo,
                    "invoicetype" => $efris->data->basicInformation->invoiceType,
                    "issuedate" => $efris->data->basicInformation->issuedDate,
                    "buyerref" => $efris->data->buyerDetails->buyerReferenceNo,
                    'dealer_id' => $sale->id,
                    'qrcode' => $efris->data->summary->qrCode,
                    'sale_id' => $saleid,
                    'inv_id'=>$efris->data->basicInformation->invoiceId,
                    'inv_no'=>$efris->data->basicInformation->invoiceNo,
                ]);

                foreach ($cart as $key => $a) {
                    $delerproduct = DealerProduct::where(['product_id' => $a['product_id'], 'dealer_id' => $dealer])->first();
                    $delerproduct->decrement('stock', intval($a['quantity']));


                    $product = Product::find($a['product_id']);
                    // if (DealerUser::find($salerid)->targettype === 'sku') {
                    //     $sku = SkuTargetProduct::where(['product_id' => $a['product_id'], 'user_id' => $salerid])->whereDate('fromdate', '>=', request()->date)
                    //         ->whereDate('todate', '<=', request()->date)->first();
                    //     if ($sku) {
                    //         $sku->increment('sold', $a['quantity']);
                    //     }

                    // }
                    // $hsvat = (0.18/118)*$product->price;
                    $dispatchp = DispatchProducts::find($a['id']);
                    SaleProduct::create([
                        'sale_id' => $sale->id,
                        'product_id' => $a['product_id'],
                        'dealer_product_id' => $delerproduct->id,
                        'name' => $a['name'],
                        'quantity' => $a['quantity'],
                        'total' => intval($a['quantity']) * $a['sellingprice'] - $a['discount'],
                        'withoutdiscount' => intval($a['quantity']) * $a['sellingprice'],
                        'sellingprice' => $a['sellingprice'],
                        'totalcost' => $product->cost * $a['quantity'],
                        //'hosanavat'=>$hsvat*$a['quantity'],
                        'customer' => $customer,
                        'van' => $van,
                        // 'product_variance_id'=>$a['variance'],
                        'route_id' => $route->route_id,
                        'discount' => $a['discount'],
                        'batch' => $a['batch'],
                        'product_brand_id' => $product->brand_id,
                        'sale_type' => $a['sale_type'],
                        'tax_id'=>$product->tax_id
                    ]);
                    if (request()->deliveryorder === "0" || request()->deliveryorder === 0) {
                        $dispatchp->increment('sold', $a['quantity']);
                        $dispatchp->decrement('stock', $a['quantity']);
                    }

                }
                //update to 1 if upload success
                $sale->update([
                    'efristatus' => 1,
                ]);
                if (request()->deliveryorder === "1" || request()->deliveryorder === 1) {
                    StockRequest::find(request()->deliveryorderid)->update([
                        'delivered' => 1,
                    ]);
                }
                // $stock = VanProduct::with('dealerproduct')->where('van_id',request()->van)->get();
                $dispatch = Dispatch::with('dispatchproducts')->where(['type' => 'van', 'van_id' => $van])->first();
                // Performance::create([
                //     'user' => $salerid,
                //     'points' => 1,
                //     'pointtype' => 'makesale',
                // ]);
                return response()->json([
                    'message' => 200,
                    'fdn' => $efris->data->basicInformation->antifakeCode,
                    'invoice' => $efris->data->basicInformation->invoiceNo,
                    'number' => $saleid,
                    'verifcode' => $efris->data->basicInformation->invoiceId,
                    'qrcode' => $efris->data->summary->qrCode,
                    'total' => $sumgross,
                    'saler' => $saler,
                    'customer' => $route,
                    'dealer' => $dealerefris,
                    'respcode' => $efris->respcode['returnStateInfo']['returnCode'],
                    'respmsg' => $efris->respcode['returnStateInfo']['returnMessage'],
                    'items' => $goodsdetails,
                    'created' => $sale->created_at,
                    'dispatchstock' => $dispatch ? $dispatch->dispatchproducts : null,
                    'efris' => 1,
                    "invoiceno" => $efris->data->basicInformation->invoiceNo,
                    'efris'=>1,
                    "vat"=>$taxamount
                ]);
            } else {
                //$sale->delete();
                EfrisFailedJob::create([
                    'sale_id'=>$sale->id,
                ]);
                return response()->json([
                    'message' => 200,
                    'respcode' => $efris->respcode['returnStateInfo']['returnCode'],
                    'respmsg' => $efris->respcode['returnStateInfo']['returnMessage'],
                    "taxamount" => intVal($taxamount),
                    "netAmount" => $efris->netAmount,
                    'gds'=>$taxDetails,
                    'goodsdets'=>$goodsdetails,
                    'tds'=>$taxDetails,

                    'message' => 200,
                'number' => $sale->id,
                'total' => $total,
                'saler' => $saler,
                'customer' => $route,
                'dealer' => $dealerefris,
                'items' => $goodsdetails,
                'created' => $sale->created_at,
                //'dispatchstock' => $dispatch ? $dispatch->dispatchproducts : [],
                "customertype" => request()->customertype,
                'efris'=>0,
                'r'=>1
                ]);
            }

        } else {
            EfrisFailedJob::create([
                'sale_id'=>$sale->id,
            ]);
            return response()->json([
                'message' => 200,
                'respcode' => $efris->respcode['returnStateInfo']['returnCode'],
                'respmsg' => $efris->respcode['returnStateInfo']['returnMessage'],
                "taxamount" => intVal($taxamount),
                "netAmount" => $efris->netAmount,
                'gds'=>$taxDetails,
                'goodsdets'=>$goodsdetails,
                'tds'=>$taxDetails,

                'message' => 200,
            'number' => $sale->id,
            'total' => $total,
            'saler' => $saler,
            'customer' => $route,
            'dealer' => $dealerefris,
            'items' => $goodsdetails,
            'created' => $sale->created_at,
            //'dispatchstock' => $dispatch ? $dispatch->dispatchproducts : [],
            "customertype" => request()->customertype,
            'efris'=>0,
            'r'=>2
            ]);
            // $sale->delete();
            // return response()->json(['message' => 500]);
        }




        //decrement from van stock
        //save sale locally
    }

    public function receiptdetails()
    {
        $items = Sale::with(['items', 'van', 'customer'])->find(request()->id);
        return response()->json(['items' => $items]);
    }

    public function savereturn()
    {
        $items = request()->items;
        $receipt = request()->receipt;
        $sale = Sale::find($receipt);
        $return = SaleReturn::create([
            'type' => 'credit',
            'receipt' => $receipt,
            'status' => 'pending',
            'van_id' => $sale->van_id,
            'requested_by' => request()->user,
            'customer_id' => $sale->customer_id,
            'sale_id' => $receipt,
        ]);
        foreach ($items as $key => $a) {
            SalesReturnItem::create([
                'return_id' => $return->id,
                'product_id' => $a['product_id'],
                'sales_product_id' => $a['id'],
                'qty_returned' => $a['returnqty'],
                'van_id' => $sale->van_id,
                'receipt' => $receipt,
                'total_returned' => $a['returnqty'] * $a['sellingprice'],
                'return_tax' => ($a['returnqty'] * $a['sellingprice']) * 0.18,
                'batch' => $a['batch'],
                'customer_id' => $sale->customer_id,
            ]);
        }

        return response()->json(['status' => 200]);
    }
}
