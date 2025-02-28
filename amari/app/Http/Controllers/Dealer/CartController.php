<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductBrand;
use App\Models\Customer;
use App\Models\Route;
use App\Models\CustomerCategory;
use App\Models\Product;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\PostdataController;
use App\Http\Controllers\Helper\Efris\InvoiceController;
use App\Models\EfrisSetting;
use App\Models\Sale;
use App\Models\EfrisDocument;
use App\Models\Stock;
use App\MOdels\DispatchProducts;
use App\Models\SaleProduct;
use App\Models\Performance;
use App\Models\Dealer;
use App\Models\Tax;
use App\Http\Controllers\Helper\Efris\TaxPayerController;

class CartController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
          $dealer = \Auth::guard('dealer')->user()->dealer->code;
        $brands = ProductBrand::all();
        $routes = Route::where('dealer_code',$dealer)->get();
        $categories = CustomerCategory::all();
        return view('dealer.pos.index',compact('brands','routes','categories'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function save(){
       //dd(request()->all());
       $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $length = 6;
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
       $shop = \DB::table('vans')
                    ->where('name', 'shop')
                    ->orWhere('name', 'Shop')
                    ->first();
        $cart = request()->products;
        $batches = request()->batches;
        $prices = request()->price;
        $discount = request()->discount;
        $units = request()->unit;
$total = 0;
        foreach($cart as $key=>$a){
            $total+= intval($units[$key])*intval($prices[$key])-$discount[$key];
        }
       //dd($total);
        $ordernumber = 0;
        $gooddetails ="";
        $goodsdetailss = array();



        $dealerefris = Dealer::find(\Auth::guard('dealer')->user()->dealer_id);
       // dd($dealerefris);
        $route = Route::find(1);
        $keypath = $dealerefris->privatekey;
        //dd($keypath);
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

        $customerdetails = Customer::find(request()->customer);
        $aeskey = $dealerefris->aeskey;
    $taxDetails = array();
            $discountdetails = "";

            $sale = Sale::create([
                'dealer_user_id'=>\Auth::guard('dealer')->user()->id,
                'route_id'=>2,
                'van_id'=>\Auth::guard('dealer')->user()->dealer_id,
                'dealer_id'=>1,
                'total'=>$total,
                'customer_id'=>request()->customer,
                'type'=>1,
                'latitude'=>'0.45',
                'longitude'=>'0.546',
                'saleidentification'=>$randomString,
                'dealer_id'=>\Auth::guard('dealer')->user()->dealer_id,
                'branch_id'=>\Auth::guard('dealer')->user()->branch_id,
              ]);

              $saleid = $sale->id;
              $taxrate = 0.18;
        foreach($cart as $key=> $a){
            //dd($discount[$key]);
            $item = Product::find($cart[$key]);

            $taxes = Tax::find($item->tax_id);

                $tax = $taxes->value > 0 ? intval($taxes->value)/100 : 0;



            $net = intval($units[$key]) * $prices[$key];
            $netamt = $net - $net * 0.18;
            $taxamm = $net * 0.18;
            $gooddetails = "";
            $discountdetails = "";


            //$taxamount = floor(($tax*(($a['sellingprice']*$a['quantity'])/1.18))*100)/100;
            $taxamountdisc = floor(($tax*($discount[$key]/1.18))*100)/100;


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
                '18' => floor(($tax*(($prices[$key]*$units[$key])/1.18))*100)/100,
                '0' => floor((0*(($prices[$key]*$units[$key])/1.18))*100)/100,
                '-' => floor((0*(($prices[$key]*$units[$key])/1.18))*100)/100,
            };


      if(intval($discount[$key])>0){
         $gooddetails = (Object)[
              "item"=> $item->name,
              "itemCode"=> $item->code,
              'goodsCategoryId'=>$item->category,
              "qty"=> $units[$key],
              "unitOfMeasure"=> $item->unit,
              "unitPrice"=> $prices[$key],
              "total"=> $prices[$key]*$units[$key],
              "taxCategoryCode"=> "01",
              "taxCategory"=>"Standard",
              "taxRate"=>$taxrate,
              "tax"=>$taxamount,
              //LINE FOR DISCOUNT
              "discountTotal"=> -$discount[$key],
              "discountTaxRate"=> "",
              "orderNumber"=> $ordernumber++,
              "discountFlag"=> "1",
              "deemedFlag"=> "2",
              "exciseFlag"=> "2",
              "categoryId"=> "1234",
              "categoryName"=> "Test",
              "commodityCategoryId"=>$item->category,
              "goodsCategoryName"=> "Test",
              "exciseRate"=> "",
              "exciseRule"=> "1",
              "exciseTax"=> "",
              "pack"=> "1",
              "stick"=> "20",
              "exciseCurrency"=> "UGX",
              "exciseRateName"=> "123"
          ];
          $discountdetails = (Object)[
            "item"=> $item->name." (Discount)",
            "itemCode"=> $item->code,
            'goodsCategoryId'=>$item->category,
            "qty"=> "",
            "unitOfMeasure"=> $item->unit,
            "unitPrice"=> "",
            "total"=> -$discount[$key],

            "taxRate"=>$taxrate,
            "tax"=>-$taxamountdisc,
            //LINE FOR DISCOUNT
            "discountTotal"=> "",
            "discountTaxRate"=> "",
            "orderNumber"=> $ordernumber++,
            "discountFlag"=> "0",
            "deemedFlag"=> "2",
            "exciseFlag"=> "2",
            "categoryId"=> "1234",
            "categoryName"=> "Test",
            "commodityCategoryId"=>$item->category,
            "goodsCategoryName"=> "Test",
            "exciseRate"=> "",
            "exciseRule"=> "1",
            "exciseTax"=> "",
            "pack"=> "1",
            "stick"=> "20",
            "exciseCurrency"=> "UGX",
            "exciseRateName"=> "123"
        ];



        $taxDetail = (Object)[
    "taxCategoryCode"=> $taxcategorycode,
            "taxCategory"=>"Standard",
            "taxRateName"=>"VAT-Standard",
            "netAmount"=>$tax > 0 ? floor((($units[$key]*$prices[$key])/1.18 + 0.18*(($prices[$key]*$units[$key])/1.18)
            -floor((0.18*(($prices[$key]*$units[$key])/1.18))*100)/100)*100)/100 :
            floor((($units[$key]*$prices[$key])/1.18 + 0.18*(($prices[$key]*$units[$key])/1.18))*100)/100,


            "taxRate"=>$taxrate,
            "taxAmount"=>$taxamount,

            "grossAmount"=>  floor((($units[$key]*$prices[$key])/1.18 + 0.18*(($prices[$key]*$units[$key])/1.18))*100)/100,
            "exciseUnit"=> "101",
            "exciseCurrency" => "UGX",
            "taxRateName" => "123",
        ];
        }else{
            $gooddetails = (Object)[
              "item"=> $item->name,
              "itemCode"=> $item->code,
              'goodsCategoryId'=>$item->category,
              "qty"=> $units[$key],
              "unitOfMeasure"=> $item->unit,
              "unitPrice"=> $prices[$key],
              "total"=> $prices[$key]*$units[$key],
              "taxCategoryCode"=> "01",
              "taxCategory"=>"Standard",
              "taxRate"=>$taxrate,
             "tax"=>$taxamount,
              //LINE FOR DISCOUNT
              "discountTotal"=> "",
              "discountTaxRate"=> "",
              "orderNumber"=> $ordernumber++,
              "discountFlag"=> "2",
              "deemedFlag"=> "2",
              "exciseFlag"=> "2",
              "categoryId"=> "1234",
              "categoryName"=> "Test",
              "commodityCategoryId"=>$item->category,
              "goodsCategoryName"=> "Test",
              "exciseRate"=> "",
              "exciseRule"=> "1",
              "exciseTax"=> "",
              "pack"=> "1",
              "stick"=> "20",
              "exciseCurrency"=> "UGX",
              "exciseRateName"=> "123"
          ];
          $taxDetail = (Object)[
            "taxCategoryCode"=> $taxcategorycode,
            "taxCategory"=>"Standard",
            "taxRateName"=>"VAT-Standard",
            "netAmount"=>$tax > 0 ? floor((($units[$key]*$prices[$key])/1.18 + 0.18*(($prices[$key]*$units[$key])/1.18)
            -floor((0.18*(($prices[$key]*$units[$key])/1.18))*100)/100)*100)/100 :
            floor((($units[$key]*$prices[$key])/1.18 + 0.18*(($prices[$key]*$units[$key])/1.18))*100)/100,


            "taxRate"=>$taxrate,
            "taxAmount"=>$taxamount,

            "grossAmount"=>  floor((($units[$key]*$prices[$key])/1.18 + 0.18*(($prices[$key]*$units[$key])/1.18))*100)/100,
            "exciseUnit"=> "101",
            "exciseCurrency" => "UGX",
            "taxRateName" => "123",
        ];

          }



         array_push($goodsdetailss,$gooddetails,$discountdetails);
          array_push($taxDetails,$taxDetail);
           }

          $removedups = array_unique( $goodsdetailss, SORT_REGULAR );
           $goodsdetails = array_values(array_filter($removedups));
           //dd($goodsdetails);
           $sumgross = 0;
           foreach($taxDetails as $key=>$value){
             if(isset($value->grossAmount))
               $sumgross += $value->grossAmount;
           }
           $summarytotal = 0;
           foreach($taxDetails as $key=>$value){
             if(isset($value->netAmount))
               $summarytotal += $value->netAmount;
           }

           $taxamount = 0;
           foreach($taxDetails as $key=>$value){
             if(isset($value-> taxAmount))
             $taxamount += $value->taxAmount;
           }
         //return response()->json(['gds'=>$taxDetails]);
         $itemcount = count($cart);
         $efris = (new InvoiceController)->saveInvoice($aeskey,$privatek,$tin,$deviceno,$goodsdetails,$taxDetails,$saleid,$total,$itemcount,$route,$dealerefris,$sumgross,$summarytotal,$taxamount,$customerdetails);
        // dd($efris);
         if($efris->status === 200){
            if($efris->respcode['returnStateInfo']['returnCode'] === "00"){
                EfrisDocument::create([
                  "fdn"=>$efris->data->basicInformation->antifakeCode,
                  "invoiceid"=>$efris->data->basicInformation->invoiceId,
                  "invoiceindustrycode"=>$efris->data->basicInformation->invoiceIndustryCode,
                  "invoicekind"=>$efris->data->basicInformation->invoiceKind,
                  "invoiceno"=>$efris->data->basicInformation->invoiceNo,
                  "invoicetype"=>$efris->data->basicInformation->invoiceType,
                  "issuedate"=>$efris->data->basicInformation->issuedDate,
                  "buyerref"=>$efris->data->buyerDetails->buyerReferenceNo,
                  'dealer_id'=>$sale->id,
                  'qrcode'=>$efris->data->summary->qrCode,
                  'sale_id'=>$saleid
                ]);

                foreach($cart as $key=> $a){
                $item = Product::find($cart[$key]);
                 $stock = Stock::find($batches[$key]);
                 $stock->increment('sold',$units[$key]);
                 $stock->decrement('amount',$units[$key]);
                 //dd($stock);
                 $hsvat = (0.18/118)*$stock->sellingprice;
                  //$dispatchp = DispatchProducts::find($a['id']);
                  SaleProduct::create([
                    'sale_id'=>$sale->id,
                    'product_id'=>$cart[$key],
                    'name'=>$item->name,
                    'quantity'=>$units[$key],
                    'total'=>intval($units[$key])*$prices[$key]-$discount[$key],
                    'withoutdiscount'=>intval($units[$key])*$prices[$key],
                    'sellingprice'=>$prices[$key],
                    'totalcost'=>$stock->cost*$units[$key],
                    'hosanavat'=>$hsvat*$units[$key],
                    'customer'=>request()->customer,
                    'van'=>\Auth::guard('dealer')->user()->id,
                   // 'product_variance_id'=>$a['variance'],
                    'route_id'=>\Auth::guard('dealer')->user()->id,
                    'discount'=>$discount[$key],
                    'batch'=>$batches[$key] ?? 35,
                    "tax_id"=>$item->tax_id
                  ]);
                //   $dispatchp->increment('sold',$a['quantity']);
                //   $dispatchp->decrement('stock',$a['quantity']);
                }
                //update to 1 if upload success
                $sale->update([
                  'efristatus'=>1
                ]);

          $receiptno = $sale->id;
          $verifcode = $efris->data->basicInformation->invoiceId;
          $qrcode = $efris->data->summary->qrCode;
          $created = $sale->created_at;
          $served = \Auth::guard('dealer')->user()->username;
          $fdn =$efris->data->basicInformation->invoiceNo;
          Performance::create([
            'user'=>\Auth::guard('dealer')->user()->id,
            'points'=>1,
            'pointtype'=>'createcustomer',
          ]);
               // $stock = VanProduct::with('dealerproduct')->where('van_id',request()->van)->get();
              // $dispatch = Dispatch::with('dispatchproducts')->where(['type'=>'van','van_id'=>$van])->first();
              //return \Redirect::back()->withErrors(['msg' => 'Order has been saved successfuly']);
              $sale->load('efrisdoc','items','customer');
              $net = 0;
              $tax =0;
              $gross = 0;
              foreach($sale->items as $item){
                $taxes = Tax::find($item->tax_id);
                $itemtax = $taxes->value === '-'?0:$taxes->value/100;
                $subtotal = $item->sellingprice;
                $totalsale = $item->quantity * $item->sellingprice;
                $total = $item->total-$item->discount;

                $taxamount = match ($taxes->value) {
                    '18' => floor(($itemtax*($totalsale/1.18))*100)/100,
                    '0' => 0,
                    '-' => 0,
                };

                $netamount = $totalsale-$taxamount;
                $net += $netamount;
                $tax +=  $taxamount;
                $gross += round( ($item->total)/1.18, 2) + round(0.18*(($item->total)/1.18), 2);
                //array_push($calcs,$taxamount);

            }
            //dd($calcs);
            $salecustomer = Customer::find($sale->customer_id);
           // dd($salecustomer);
            $customer = $salecustomer->tin ? (new TaxPayerController)->getTaxPayer($deviceno,$tin,$privatek,$aeskey,$salecustomer->tin):$salecustomer;
              return view('dealer.pos.receipt',compact('sale','total','fdn','goodsdetails',
              'receiptno','verifcode','qrcode','created','dealerefris','served','gross','net','tax','customer'));
              }else{
                $sale->delete();
                return \Redirect::back()->withErrors(['msg' => 'Order has failed to save because of '.$efris->respcode['returnStateInfo']['returnMessage']]);
              }

         }else{
            $respmsg = $efris->respcode['returnStateInfo']['returnMessage'];
            $respcode = $efris->respcode['returnStateInfo']['returnCode'];
            return \Redirect::back()->withErrors(['msg' => 'Error has occured, '.$respmsg." ".$respcode]);
         }

    }
    public function savecustomer(){
      $dealer = \Auth::guard('dealer')->user()->dealer_id;
        Customer::create(
            [
                'name'=>request()->name,
                'phone'=>request()->phone,
                'category_id'=>request()->category,
                'route_id'=>request()->route,
                'dealer_id'=>$dealer,
                'status'=>1,
                'identification'=> uniqid(),
                'tin'=>request()->tin,
                'efrisstatus'=>request()->efrisstatus,
                'category'=>request()->category,
                'buyerType'=>request()->buyertype,
                'address'=>request()->address
            ]
            );
        $customers = Customer::all();
        Performance::create([
          'user'=>\Auth::guard('dealer')->user()->id,
          'points'=>1,
          'pointtype'=>'createcustomer',
        ]);
        return response()->json(['customers'=>$customers]);
    }
    public function getcustomers(){
        $customers = Customer::where('dealer_id',\Auth::guard('dealer')->user()->dealer_id)->get();
        return response()->json(['customers'=>$customers]);
    }
}
