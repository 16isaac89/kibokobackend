<?php

namespace App\Http\Controllers\dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{

    public function index(){
        $suppliers = Supplier::where('dealer_id',\Auth::guard('dealer')->user()->dealer_id)->get();
        return view('dealer.supplier.index',compact('suppliers'));
    }
    public function editview(){
        $supplier = Supplier::find(request()->supplier);
        return view('dealer.supplier.edit',compact('supplier'));
    }
public function create(){
    return view('dealer.supplier.create');
}


    public function store(){
        Supplier::create([
        'tin'=>request()->tin,
        'name'=>request()->name,
        'address'=>request()->address,
        'phone'=>request()->phone,
        'email'=>request()->email,
        'dealer_id'=>\Auth::guard('dealer')->user()->dealer_id
        ]);
        return redirect()->route('dealersuppliers.index');
    }

    public function edit(Supplier $dealersupplier){
        $supplier = $dealersupplier;
        return view('dealer.supplier.edit',compact('supplier'));
    }
    public function update(Supplier $dealersupplier){
       // dd($dealersupplier);
        $dealersupplier->update([
        'tin'=>request()->tin,
        'name'=>request()->name,
        'address'=>request()->address,
        'phone'=>request()->phone,
        'email'=>request()->email,
        ]);
      return redirect()->route('dealersuppliers.index');
    }
    public function checktin(){
        $tin2 = request()->tin;
        $dealerefris = Dealer::find(\Auth::guard('dealer')->user()->dealer_id);
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        //$aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $aeskey = $dealerefris->aeskey;
        $payer = (new TaxPayerController)->getTaxPayer($deviceno,$tin,$privatek,$aeskey,$tin2);
        return response()->json(['taxpayer'=>$payer]);

    }
}
