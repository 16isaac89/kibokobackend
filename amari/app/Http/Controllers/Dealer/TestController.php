<?php

namespace App\Http\Controllers\Dealer;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper\Efris\ProductController;
use App\Models\Dealer;
use App\Models\DealerProduct;
use App\Models\EfrisSync;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\TaxPayerController;


class TestController extends Controller
{
    public function index(){
        $item = DealerProduct::with('product','sync')->find(request()->product);
        $dealerefris = Dealer::find(1);
       
        $keypath = $dealerefris->privatekey;
        $keypwd = $dealerefris->keypwd;
        $tin = $dealerefris->tin;
        $tin2 = "1009262445";
        $deviceno = $dealerefris->deviceno;
        $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
        $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
        $payer = (new TaxPayerController)->getTaxPayer($deviceno,$tin,$privatek,$aeskey,$tin2);
       dd($payer);
    
    }
}
