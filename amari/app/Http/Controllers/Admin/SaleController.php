<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;
use App\Models\Dealer;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\PostdataController;
use App\Http\Controllers\Helper\Efris\NotesController;
use App\Http\Controllers\Helper\Efris\GoodsTaxDetails;
use App\Models\SaleProduct;
use App\Models\EfrisNoteDocument;
use App\Models\Product;
use App\Models\Customer;
use App\Models\EfrisSetting;



class SaleController extends Controller
{
    public function index(){
        
        $sales = Sale::with('dealer','user','van','route','items','customer')->get();
        return view('admin.sales.index',compact('sales'));

    }
    public function invoices(){

    }
    public function receipts(){
        
    }
    public function invoicessearch(){
        
    }
    public function receiptssearch(){
        
    }
    public function search(){
        
        $from = request()->date1;
        $to = request()->date2;
        $search = request()->search;
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        switch ($search) {
            case 0:
                $sales = Sale::with('dealer','user','van','route','items','customer')
                ->where(['dealer_id'=>$dealer,'type'=>0])
                ->whereBetween('created_at', [$from, $to])->get();
return view('dealer.sales.index',compact('sales'));
                break;
            case 1:
                $sales = Sale::with('dealer','user','van','route','items','customer')
                ->where(['dealer_id'=>$dealer,'type'=>1])
                ->whereBetween('created_at', [$from, $to])->get();
return view('dealer.sales.index',compact('sales'));
                break;
            case 2:
                $sales = Sale::with('dealer','user','van','route','items','customer')
                ->where('dealer_id',$dealer)
                ->whereBetween('created_at', [$from, $to])->get();
return view('dealer.sales.index',compact('sales'));
                break;
        }
   
    }
    public function creditnoteview(){
        $sale = Sale::with('items','customer','user','van','route','efrisdoc')->find(request()->sale);
        return view('admin.sales.creditnote',compact('sale'));
    }

    public function debitnoteview(){
        // if(\Auth::guard('dealer')->check()){
        $sale = Sale::with('items','customer','user','van','route','efrisdoc')->find(request()->sale);
        return view('admin.sales.debitnote',compact('sale'));
    // }else{
    //     return redirect()->back()->with('errors', $response->respcode['returnStateInfo']["returnMessage"]); 
       
    // }
    }


    public function creditdebitnote(){
        //dd(request()->all());
        if(\Auth::guard('dealer')->check()){
        $reasoncode = request()->reasoncode;
        $items = request()->product;
        $units = request()->unit;
        $id = request()->sale;
        $itemcount = count($items);
        $reason = request()->reasontext;
        $note = request()->note;
        $sale = Sale::with('efrisdoc','items')->find(request()->saleid);
        //$items = $sale->items;
        $doc = $sale->efrisdoc;
        $dealerefris = EfrisSetting::find(1);
        $keypath = $dealerefris->keypath;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        
        $details = (new GoodsTaxDetails)->goodtaxdetails($items,$units);
        $response = (new NotesController)->creditnote($deviceno,$tin,$privatek, $aeskey,$reason,$details,$doc,$itemcount,$reasoncode);

        if($response->respcode['returnStateInfo']["returnCode"]=== "00"){
        foreach($items as $a => $b){
            $item = SaleProduct::with('product')->find($items[$a]);
            $finalunits = $item->quantity-$units[$a];

            $product = Product::find($item->product_id);
            $item->deduction = $units[$a];
            $item->total = $finalunits*$product->price;
            $item->save();
            $item->decrement('quantity',$units[$a]);
        }
        EfrisNoteDocument::create([
            'sale_id'=>$sale->id,
            'type'=>'1',
            'reference'=>$response->data->referenceNo,
            'efris_document_id'=>$sale->efrisdoc->id,
            'status'=> "1",
        ]);
        return redirect()->back()->with('success', 'Credit note has been issued'); 
    }else{
        return redirect()->back()->with('errors', $response->respcode['returnStateInfo']["returnMessage"]); 
       
    }

}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}

    }

    public function notestatus(){
        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        
        $dealerefris = EfrisSetting::find(1);
        $keypath = $dealerefris->keypath;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        
        $response = (new NotesController)->getstatus($deviceno,$tin,$privatek, $aeskey);
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }


    public function debitnote(){
        //  dd(request()->all());
         if(\Auth::guard('dealer')->check()){
            
            $items = request()->product;
            $units = request()->unit;
            $id = request()->saleid;
            $itemcount = count($items);
            $reason = request()->reasontext;

            $total = 0;
            foreach($items as $a => $b){
                $item = SaleProduct::with('product')->find($items[$a]);
                $product = Product::find($item->product_id);
                $total+=$units[$a]*$product->price;
            }
            $sale = Sale::with('efrisdoc','items')->find($id);
            //dd($sale->efrisdoc->invoiceid);
            //$items = $sale->items;
            $route = Customer::where('identification',$sale->customer_id)->first();
            $saleid = $sale->id;
            $invid = $sale->efrisdoc->invoiceid;
            // $dealerefris = Dealer::find($sale->dealer_id);
            $doc = $sale->efrisdoc;

            $dealerefris = EfrisSetting::find(1);
        $keypath = $dealerefris->keypath;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
            
            $details = (new GoodsTaxDetails)->debitgoodstaxdetails($items,$units);
           
            $response = (new NotesController)->debitnote($deviceno,$tin,$privatek, $aeskey,$details,$doc,$itemcount,$invid,$dealerefris,$saleid,$total,$route);
    
            if($response->respcode['returnStateInfo']["returnCode"]=== "00"){
            foreach($items as $a => $b){
                $item = SaleProduct::with('product')->find($items[$a]);
                $finalunits = $units[$a];

                $product = Product::find($item->product_id);
                $item->addition = $units[$a];
                $item->total = $finalunits*$product->price;
                $item->quantity = $units[$a];
                $item->save();
               

            }
            EfrisNoteDocument::create([
                'sale_id'=>$sale->id,
                'type'=>'2',
                'efris_document_id'=>$sale->efrisdoc->id,
                'status'=> "1",
            ]);
            return redirect()->back()->with('success', 'Credit note has been issued'); 
        }else{
            return redirect()->back()->with('errors', $response->respcode['returnStateInfo']["returnMessage"]); 
           
        }
    
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    
    }



    public function deduct(){
        $reasoncode = request()->reasoncode;
        $items = request()->product;
        $units = request()->unit;
        $id = request()->sale;
        $itemcount = count($items);
        $reason = request()->reasontext;
        $note = request()->note;
        $sale = Sale::with('efrisdoc','items')->find(request()->saleid);
        $reason = request()->reasontext;
        $totalcost = request()->totaldeduction;
        $totalsales = sum($$totalcost);
        $sale = Sale::find(request()->saleid);

        SaleReturn::create([
            'sale_id'=>$sale->id,
            'amount'=>$totalsales,
            'reason'=>request()->reasontext,
            'amount_before'=>$sale->total,
        ]);

        foreach($items  as $a => $b){
            $item = SaleProduct::find($items[$a]);
            SaleReturnItem::create([
                'product_id'=>$item->product_id,
                'sales_product_id'=>$item->id,
                'qty_returned'=>$units[$a],
                'van_id'=>$sale->van_id,
                'return_date'=>request()->returndate,
                'total_returned'=>$totalcost[$a],
                'return_tax'=>$totalcost[$a]*0.18,
                'batch'=>$item->batch,
            ]);
            $item->quantity = $item->quantity-$units[$a];
            $item->total = $totalcost[$a];
            $item->save();
        }
        
        
        $sale->totalbefore = $sale->total;
        $sale->total = $totalsales;
        $sale->save();
        return redirect()->back()->with('success', 'Credit note has been issued'); 
    }
   


    
}
