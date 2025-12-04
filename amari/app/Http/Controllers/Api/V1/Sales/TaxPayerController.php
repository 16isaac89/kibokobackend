<?php

namespace App\Http\Controllers\api\v1\sales;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\TaxPayerController as TaxPayer;
use App\Models\Dealer;
use Illuminate\Http\Request;

class TaxPayerController extends Controller
{
    public function taxpayer(Request $request){
         $dealer = Dealer::find(12);
    // dd($dealer);

    // foreach($dealers as $dealer){
    $keypath  = $dealer->privatekey;
    $keypwd   = $dealer->keypwd;
    $tin      = $dealer->tin;
    $deviceno = $dealer->deviceno;
    // $token =
    //dd($keypath);
    $privatek = (new KeysController)->getPrivateKey($keypath, $keypwd);
	$aeskey = $dealer->aeskey;
    $tin2 = $request->tin;

	$taxpayer = (new TaxPayer)->getTaxPayer($deviceno,$tin,$privatek,$aeskey,$tin2);
        return response()->json(['taxpayer'=>$taxpayer]);
    }
}
