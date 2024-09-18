<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\PostdataController;
use App\Http\Controllers\Helper\Efris\InvoiceController;
use Carbon\Carbon;
use App\Models\EfrisSetting;

class EfrisSetupController extends Controller
{
    public function getkey(){
        $dealer = EfrisSetting::find(1);
        // foreach($dealers as $dealer){
            $keypath = $dealer->keypath;
            $keypwd = $dealer->keypwd;
            $tin = $dealer->tin;
            $deviceno = $dealer->deviceno;
            $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
            $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);
            $dealer = EfrisSetting::find(1);
            if($aeskey){
            $dealer->aeskey = $aeskey;
            $dealer->save();
            return response()->json(['status'=>1,'date'=>$dealer->updated_at]); 
            }else{
                return response()->json(['status'=>0,'date'=>$dealer->updated_at]);
            }
           

    }
}
