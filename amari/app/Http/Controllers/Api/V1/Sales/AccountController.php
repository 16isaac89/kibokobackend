<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Target;
use App\Models\Sale;
use Carbon\Carbon;
use App\Models\Dealer;
use App\Models\DealerProduct;
use App\Models\EfrisSync;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\TaxPayerController;
use App\Models\EfrisSetting;
use App\Models\DealerUser;

class AccountController extends Controller
{
    public function status(){
    $dealer = DealerUser::with('dealer')->find(request()->id);
    // return response()->json(['target'=>$dealer->dealer]);
    $user_dealer_type = $dealer->dealer->type_of_business;
    $targetsales = Target::whereMonth('month', Carbon::now()->month)->where(['type'=>'saler','dealer_user_id'=>request()->id])->first();
    $target = "";
    if($targetsales){
$target = $targetsales->money;
    }else{
        $target = 0;
    }
    //return response()->json(['target'=>$target]);
    //$target = count($targetsales)>0 ? 0 : $targetsales[0]->money;
    $sales = Sale::whereMonth('created_at', Carbon::now()->month)->where('dealer_user_id',request()->id)->sum('total');
   // return response()->json(['target'=>$sales]);
    $balance = $sales-$target;
     return response()->json(['target'=>$target,'status'=>$sales,'balance'=>$balance,'user_dealer_type'=>$user_dealer_type]);
    }

    public function getdealer(){
        $dealer = Dealer::find(request()->id);
        return response()->json(['dealer'=>$dealer]);
    }
    public function gettaxpayer(){
        $tin2 = request()->tin;
        $dealerefris = Dealer::find(request()->dealer);
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
    public function efrisstatus(){
        $dealer = Dealer::find(request()->id);
        return response()->json(['status'=>$dealer->efris]);
    }
}
