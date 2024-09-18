<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Controllers\Helper\Efris\TaxPayerController;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Models\Dealer;
use App\Models\EfrisSync;
use App\Models\EfrisSetting;

class SuppliersController extends Controller
{


    public function index(){
        $suppliers = Supplier::all();
        return view('admin.suppliers.index',compact('suppliers'));
    }
    public function editview(){
        $supplier = Supplier::find(request()->supplier);
        return view('admin.suppliers.edit',compact('supplier'));
    }



    public function add(){
        Supplier::create([
        'tin'=>request()->tin,
        'name'=>request()->name,
        'address'=>request()->address,
        'phone'=>request()->phone,
        'email'=>request()->email,
        ]);
        $suppliers = Supplier::all();
        return view('admin.suppliers.index',compact('suppliers'));
    }

    public function edit(){
        Supplier::find(request()->supplier)->update([
        'tin'=>request()->tin,
        'name'=>request()->name,
        'address'=>request()->address,
        'phone'=>request()->phone,
        'email'=>request()->email,
        ]);
        $suppliers = Supplier::all();
        return view('admin.suppliers.index',compact('suppliers'));
    }
    public function checktin(){
        $tin2 = request()->tin;
        $dealerefris = EfrisSetting::find(1);
        $keypath = $dealerefris->keypath;
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
