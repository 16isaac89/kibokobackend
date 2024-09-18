<?php
namespace App\Http\Controllers\Dealer;

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
use App\Models\SaleReturn;
use App\Models\EfrisSetting;
use App\Models\Stock;
use App\Http\Controllers\Helper\Efris\TaxPayerController;
use App\Models\Tax;


class SaleController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;
        //$sales = Sale::with('dealer','user','van','route','items','customer')->where('dealer_id',$dealer)->whereDate('created_at', Carbon::today())->get();
        $sales = Sale::with('dealer','user','van','route','items','customer')->where('dealer_id',$dealer)->get();
        return view('dealer.sales.index',compact('sales'));
    }else{
        return redirect()->back()->with('errors', $response->respcode['returnStateInfo']["returnMessage"]);

    }
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
        if(\Auth::guard('dealer')->check()){
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
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');

    }


    }
    public function creditnoteview(){
        if(\Auth::guard('dealer')->check()){
        $sale = Sale::with('items','customer','user','van','route','efrisdoc')->find(request()->sale);
        return view('dealer.sales.creditnote',compact('sale'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');

    }
    }

    public function debitnoteview(){
        //if(\Auth::guard('dealer')->check()){
        $sale = Sale::with('items','customer','user','van','route','efrisdoc')->find(request()->sale);
        return view('dealer.sales.debitnote',compact('sale'));
    // }else{
    //     return redirect()->back()->with('errors', $response->respcode['returnStateInfo']["returnMessage"]);

    // }
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

        Reduction::create([
            'sale_id'=>$sale->id,
            'amount'=>$totalsales,
            'reason'=>request()->reasontext,
            'amount_before'=>$sale->total,
        ]);

        foreach($items  as $a => $b){
            $item = SaleProduct::find($items[$a]);
            SaleReturn::create([
                    'type'=>'1',
                    'sales_item'=>$item->id,
                    'quantity'=>$units[$a],
                    'total'=>$totalcost[$a],
                    'qtybefore'=>$item->quantity,
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


    public function creditdebitnote(){
       //dd(request()->all());
       $saleid = request()->saleid;

        // if(\Auth::guard('dealer')->check()){
        $reasoncode = request()->reasoncode;
        $items = request()->product;
        $units = request()->unit;
        $id = request()->sale;
        $itemcount = count($items);
        $reason = request()->reasontext;
        $note = request()->note;
        $sale = Sale::with('efrisdoc','items')->find(request()->saleid);
        //$items = $sale->items;

        $total = 0;


        $dealerefris = \Auth::guard('dealer')->user()->dealer;
        $doc = $sale->efrisdoc;
       // dd($doc);
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
       // $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $details = (new GoodsTaxDetails)->goodtaxdetails($items,$units);
        $response = (new NotesController)->creditnote($deviceno,$tin,$privatek, $aeskey,$reason,
        $details,$doc,$itemcount,$reasoncode,$dealerefris);
       // dd($sale);
// dd($response,json_decode($response->data, true));

        if($response->respcode['returnStateInfo']["returnCode"]=== "00"){
        foreach($items as $a => $b){
            $item = SaleProduct::with('product')->find($items[$a]);
            $batch = Stock::find($item->batch);

            $finalunits = $item->quantity-$units[$a];

            $product = Product::find($item->product_id);
            $item->deduction = $units[$a];
            $item->total = $finalunits*$product->price;
            $item->save();
            //decrease total in sale receipt and increase in stock
            $item->credit_note_value = $units[$a];
            $item->save();
            //$item->decrement('quantity',$units[$a]);
            $batch->increment('amount',$units[$a]);
        }
        $data = json_decode($response->data, true);
        //dd($data);
        EfrisNoteDocument::create([
            'sale_id'=>$sale->id,
            'type'=>'1',
            'reference'=>$data["referenceNo"],
            'efris_document_id'=>$sale->efrisdoc->id,
            'status'=> "1",
        ]);
        foreach($items as $a => $b){
            $item = SaleProduct::with('product')->find($items[$a]);
            $newtotal = $item->total-$item->sellingprice*$units[$a];
            $total+=$newtotal;
            $item->update([
                'total'=>$newtotal,
            ]);
        }
        $sale->decrement('total',$total);
        return redirect()->back()->with('success', 'Credit note application successful.');
    // }else{
    //     return redirect()->back()->with('errors', $response->respcode['returnStateInfo']["returnMessage"]);

    // }

}else{
    return redirect()->back()->with('error', 'Credit note has already been issued');
}

    }

    public function notestatus(){
        if(\Auth::guard('dealer')->check()){
        $dealer = \Auth::guard('dealer')->user()->dealer_id;

        $dealerefris = Dealer::find($dealer);
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;

        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

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
            $dealerefris = Dealer::find($sale->dealer_id);
            $doc = $sale->efrisdoc;
            $keypath = $dealerefris->privatekey;
            $keypwd = $dealerefris->keypwd;
            $tin = $dealerefris->tin;
            $deviceno = $dealerefris->deviceno;
            $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
            $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

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
public function receiptview(Sale $sale){
    $sale->load('efrisdoc','items','customer');
    $dealer = \Auth::guard('dealer')->user()->dealer;
    $net = 0;
    $tax =0;
    $gross = 0;
   // $calcs = array();
    // dd($sale->items);
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
    $customer = $sale->customer_id?Customer::find($sale->customer_id):null;
   // dd($sale);
  //  dd($customer);
    if(\Auth::guard('dealer')->user()->dealer->efris === 1 && $customer->tin){
        $tin2 = $sale->customer->tin;
        $dealerefris = $dealer;
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $customer = (new TaxPayerController)->getTaxPayer($deviceno,$tin,$privatek,$aeskey,$tin2);
        return view('dealer.sales.viewreceipt',compact('sale','customer','dealer','gross','net','tax'));
    }else{

        return view('dealer.sales.viewreceipt',compact('sale','customer','dealer','gross','net','tax'));
    }


}





}
