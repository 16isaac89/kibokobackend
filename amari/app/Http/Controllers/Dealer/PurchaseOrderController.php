<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductBrand;
use App\Models\Supplier;
use App\Models\PurchaseOrderProducts;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Stock;
use Auth;

class PurchaseOrderController extends Controller
{
    public function index(){
        $purchases = [];
        $dealer  = Auth::guard('dealer')->user()->dealer_id;
        $suppliers = Supplier::where('dealer_id',$dealer)->get();
        return view('dealer.purchases.index',compact('purchases','suppliers'));
       }
       public function create(){
        $dealer  = Auth::guard('dealer')->user()->dealer_id;
        $brands = ProductBrand::where('dealer_id',$dealer)->get();
        $suppliers = Supplier::where('dealer_id',$dealer)->get();
        return view('dealer.purchases.create',compact('brands','suppliers'));
       }
       public function store(){
       //dd(request()->all());
        $totals  = request()->total;
        $total =array_sum($totals);
        $brands = request()->brands;
        $products = request()->products;
        $units = request()->units;
        $prices = request()->prices;
        $purchase = PurchaseOrder::create([
            'total'=>$total,
            'status'=>request()->status,
            'supplier_id'=>request()->supplier,
            'reference'=>rand(100000,999999),
            'date'=>request()->date,
            'ordered_by'=>\Auth::user()->id,
            'item_count'=>count($products),
            'dealer_id'=>Auth::guard('dealer')->user()->dealer_id
        ]);
        foreach($products as $a => $b){
            PurchaseOrderProducts::create([
                'brand_id'=>$brands[$a],
                'product_id'=>$products[$a],
                'cost'=>$prices[$a],
                'purchase_order_id'=>$purchase->id,
                'req_quantity'=>$units[$a],
                'total_cost'=>$totals[$a],
            ]);
        }
        return redirect()->back()->with('success', 'Purchase order successfully saved');
       }
       public function search(){
        // dd(request()->all());
        $from = date(request()->fromdate);
        $to = date(request()->todate);
        $purchases = PurchaseOrder::with(['supplier','user'])->where(['supplier_id'=>request()->supplier,'status'=>request()->status])
                                    ->whereBetween('date', [$from, $to])->get();
        $suppliers = Supplier::all();
        return view('dealer.purchases.index',compact('purchases','suppliers'));
       }

       public function edit(){
        $purchaseorder = PurchaseOrder::with(['products'=>function($query){
            $query->with('product');
        }])->find(request()->id);
       // dd($purchaseorder);
        $brands = ProductBrand::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        $purchaseorderid = request()->id;
        return view('dealer.purchases.edit',compact('purchaseorder','brands','suppliers','products','purchaseorderid'));
       }
       public function receiveview(){
        $purchaseorder = PurchaseOrder::with(['products'=>function($query){
            $query->with('product');
        }])->find(request()->id);
        $brands = ProductBrand::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        $purchaseid = $purchaseorder->id;
        return view('dealer.purchases.receive',compact('purchaseorder','brands','suppliers','products','purchaseid'));
       }
       public function receivepost(){
        $orderproducts = request()->products;
        $receivedunits  = request()->receivedunits;
        $receivedprices  = request()->receivedprices;
        $expdates   = request()->expirydates;
        $sellingprices  = request()->sellingprices;
        $supplier = request()->supplier;
        $invoice = request()->invnumber;
        $receivedate  = request()->receivedate;
        $status  = request()->status;
        $purchaseorder = PurchaseOrder::find(request()->purchaseid);
        $purchaseorder->invoicenumber = $invoice;
        $purchaseorder->receivedate = $receivedate;
        $purchaseorder->status = 'received';
        $purchaseorder->save();

        foreach($orderproducts as $a => $b){
            $item = PurchaseOrderProducts::find($orderproducts[$a]);
            $item->actual = $receivedprices[$a];
            $item->received_quantity = $receivedunits[$a];
            $item->expirydate = $expdates[$a];
            $item->actual_total = $receivedunits[$a]*$receivedprices[$a];
            $item->save();
            Stock::create([
            'product_id'=>$item->product_id,
            'amount'=>$receivedunits[$a],
            'sellingprice'=>$receivedprices[$a],
            'batch'=>$invoice,
            'receivedate'=>$receivedate,
            'expirydate'=>$expdates[$a]
            ]);
        }

        return redirect()->route('dealer.purchases.index')->with('message', 'Purchase order received successfuly.');
        //return redirect()->route('dealer.purchases.index');
        //dd(request()->all());
       }
       public function postedit(){
        $purchaseorder = request()->purchaseorder;
        $supplier = request()->supplier;
        $ref = request()->ref;
        $date = request()->date;
        $status = request()->status;
        //exists
        $existsbrands = request()->existsbrands;
        $exists = request()->exists;
        $existsprices = request()->existsprices;
        $existsunits = request()->existsunits;
        $existstotal = request()->existstotal;

        //new
        $brands = request()->brands;
      $products  = request()->products;
      $prices  = request()->prices;
      $units  = request()->units;
      $totals  = request()->total;
      foreach($exists as $a => $b ){
        $item = PurchaseOrderProducts::find($exists[$a]);
        if($existsunits[$a] == 0){
            $item->delete();
        }else{
        $item->brand_id = $existsbrands[$a];
        $item->cost = $existsprices[$a];
        $item->req_quantity = $existsunits[$a];
        $item->total_cost = $existstotal[$a];
        $item->save();
        }
      }
      foreach($products as $a => $b){
        PurchaseOrderProducts::create([
            'brand_id'=>$brands[$a],
            'product_id'=>$products[$a],
            'cost'=>$prices[$a],
            'purchase_order_id'=>$purchaseorder,
            'req_quantity'=>$units[$a],
            'total_cost'=>$totals[$a],
        ]);
    }
    PurchaseOrder::find($purchaseorder)->update([
        'status'=>$status,
    ]);
    return redirect()->back()->with('success', 'Purchase order successfully edited.');
       // dd(request()->all());
       }


       public function returnview(){
        $purchaseorder = PurchaseOrder::with(['products'=>function($query){
            $query->with('product');
        }])->find(request()->id);
        $brands = ProductBrand::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        $purchaseid = $purchaseorder->id;

       // dd($purchaseorder);
        return view('dealer.purchases.return',compact('purchaseorder','brands','suppliers','products','purchaseid'));
       }
       public function returnpurchase(){
        $total = array();
        $purchaseorder = PurchaseOrder::find(request()->purchaseid);
        $products = request()->products;
        $returnqtys = request()->returnqtys;
        foreach($products as $a=>$b){
            $purchaseproduct = PurchaseOrderProducts::find($products[$a]);
            $price = $purchaseproduct->cost;
            $quantity = $purchaseproduct->received_quantity-$returnqtys[$a];
            $purchaseproduct->actual_total = $price*$quantity;
            $purchaseproduct->save();
            $purchaseproduct->decrement('received_quantity',$returnqtys[$a]);
            $stock = Stock::where(['batch'=>$purchaseorder->invoicenumber,'product_id'=>$purchaseproduct->product_id])->first();
            $stock->decrement('amount',$returnqtys[$a]);
        }
        return redirect()->back()->with('success', 'Purchase successfully returned.');
        //dd(request()->all());
       }
}
