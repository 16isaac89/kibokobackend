<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EfrisFailedJob;
use App\Models\Sale;
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

use App\Models\SaleProduct;
use App\Models\SaleReturn;
use App\Models\SalesReturnItem;
use App\Models\SkuTargetProduct;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Tax;
use App\Models\DealerProduct;

class CheckEfrisFailedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:efris-failed-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for EfrisFailedJobs and find associated Sales';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Retrieve all EfrisFailedJobs
        $failedJobs = EfrisFailedJob::all();

        if ($failedJobs->isEmpty()) {
            $this->info('No EfrisFailedJobs found.');
            return 0;
        }

        $this->info('EfrisFailedJobs found. Processing...');

        // Process each failed job and find the corresponding Sale
        foreach ($failedJobs as $job) {
            $sale = Sale::with(['items'=>function($query){
                $query->with('product','dealerproduct');
            }])->find($job->sale_id);

            if ($sale) {
                $cart = $sale->items;
                $customerdetails = Customer::where('identification', $sale->saleidentification)->first();

        $dealerefris = Dealer::find($sale->dealer_id);
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


        foreach ($cart as $cart) {
            $item = $cart->product;
            $dealerproduct = $cart->dealerproduct;

            $taxes = Tax::find($item->tax_id);

            $tax = $taxes->value > 0 ? intval($taxes->value)/100 : 0;



            $net = intval($cart->quantity) * $cart->sellingprice;
            $netamt = $net - $net * 0.18;
            $taxamm = $net * 0.18;
            $gooddetails = "";
            $discountdetails = "";


            //$taxamount = floor(($tax*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100;
            $taxamountdisc = floor(($tax*($cart->discount/1.18))*100)/100;


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
                '18' => floor(($tax*(($cart->sellingprice*$cart->quantity)/1.18))*100)/100,
                '0' => floor((0*(($cart->sellingprice*$cart->quantity)/1.18))*100)/100,
                '-' => floor((0*(($cart->sellingprice*$cart->quantity)/1.18))*100)/100,
            };

            if ($a['discount'] > 0) {
                $gooddetails = (Object) [
                    "item" => $item->name,
                    "itemCode" => $item->code,
                    'goodsCategoryId' => $item->efriscategorycode,
                    "qty" => $item->quantity,
                    "unitOfMeasure" => $item->unit,
                    "unitPrice" => $cart->sellingprice,
                    "total" => $cart->sellingprice * $cart->quantity,

                    "taxRate"=>$taxrate,
                    "tax"=>$taxamount,
                    // "taxRate"=> $taxes->value > 0 ? $taxes->value/100 : '0',
                    // "tax"=> $taxes->value > 0 ? $taxamount : '0',
                    //LINE FOR DISCOUNT
                    "discountTotal" => -$cart->discount,
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

                    "total" => -$cart->discount,
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

                    "netAmount"=>$tax > 0 ? floor((($cart->quantity*$cart->sellingprice)/1.18 +
                    0.18*(($cart->sellingprice*$cart->quantity)/1.18)-floor((0.18*(($cart->sellingprice*$cart->quantity)/1.18))
                    *100)/100)*100)/100 : floor((($cart->quantity*$cart->sellingprice)/1.18 + 0.18*(($cart->sellingprice
                    *$cart->quantity)/1.18))*100)/100,
                    //'netAmount'=>5*$sellingprice,
                    "taxRate"=>$taxrate,
                    "taxAmount"=>$taxamount,
                    //"taxAmount"=>"0",
                    //"grossAmount"=>  floor((($a['quantity']*$a['sellingprice'])/1.18 + 0.18*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100,
                    //"taxAmount"=>"0",
                    //"grossAmount"=>  $a['quantity']*$a['sellingprice'],
                    //"grossAmount" => $a['sellingprice'] * $a['quantity'] - $a['discount'],
                    "grossAmount"=>  floor((($cart->quantity*$cart->sellingprice)/1.18 + 0.18*(($cart->sellingprice
                    *$a['quantity'])/1.18))*100)/100,


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
                    "qty" => $cart->quantity,
                    "unitOfMeasure" => $item->unit,
                    "unitPrice" => $cart->sellingprice,
                    "total" => $cart->sellingprice * $cart->quantity,
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

                    "netAmount"=>$tax > 0 ? floor((($cart->quantity*$cart->sellingprice)/1.18 + 0.18
                    *(($cart->sellingprice*$cart->quantity)/1.18)-floor((0.18*(($cart->sellingprice
                    *$cart->quantity)/1.18))*100)/100)*100)/100 : floor((($cart->quantity*$cart->sellingprice)/1.18 + 0.18
                    *(($cart->sellingprice*$cart->quantity)/1.18))*100)/100,
                    //'netAmount'=>5*$sellingprice,
                    "taxRate"=>$taxrate,
                    "taxAmount"=>$taxamount,
                    //"taxAmount"=>"0",
                    "grossAmount"=>  floor((($cart->quantity*$cart->sellingprice)/1.18 + 0.18*(($cart->sellingprice
                    *$cart->quantity)/1.18))*100)/100,



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
        if ($efris->status === 200) {
            $job->forceDelete();
        }


                //$this->info("Sale ID: {$sale->id} found for EfrisFailedJob ID: {$job->id}");
                // Add additional logic here if needed
            } else {
                $this->warn("No Sale found for EfrisFailedJob ID: {$job->id}");
            }
        }

        $this->info('Processing completed.');
        return 0;
    }
}
