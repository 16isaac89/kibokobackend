<?php

namespace App\Http\Controllers\Helper\Efris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTimeZone;
use DateTime;

class PostdataController extends Controller
{
    
    public function post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode){
        
      
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d H:i:s');
       return json_encode(array(
            "data"=>array(
            "content"=> $encryptedcontent,
            "signature"=> $base64signature,
            "dataDescription"=>array(
            "codeType"=>1,
            "encryptCode"=>1,
            "zipCode"=>0
            )
            ),
            "globalInfo"=>array(
            "appId"=> "AP04",
                    "brn"=> "",
                    "dataExchangeId"=> "9230489223014123",
                    "deviceMAC"=> "123",
                    "deviceNo"=> $deviceNo,
                    "interfaceCode"=> $interfaceCode,
                    "requestCode"=> "TP",
                    "requestTime"=> $datetime,
                    "responseCode"=> "TA",
                    "taxpayerID"=> "1",
                    "tin"=> $tin,
                    "userName"=> "admin",
                    "version"=> "1.1.20191201",
                    "longitude"=> "116.397128",
                    "latitude"=> "39.916527",
                    "extendField"=> array(
                    "responseDateFormat"=> "yyyy/MM/dd",
                    "responseTimeFormat"=> "yyyy/MM/dd HH:mm:ss",
                    "referenceNo"=> "")
            ),
            "returnStateInfo"=>array(
             "returnCode"=> "",
                    "returnMessage"=> ""
            )
            ));
    }



    public function post_data2($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode){
       // $encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode
       
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d H:i:s');
       return json_encode(array(
            "data"=>array(
            "content"=> $encryptedcontent,
            "signature"=> $base64signature,
            "dataDescription"=>array(
            "codeType"=>1,
            "encryptCode"=>1,
            "zipCode"=>0
            )
            ),
            "globalInfo"=>array(
            "appId"=> "AP04",
                    "brn"=> "",
                    "dataExchangeId"=> "9230489223014123",
                    "deviceMAC"=> "123",
                    "deviceNo"=> $deviceNo,
                    "interfaceCode"=> $interfaceCode,
                    "requestCode"=> "TP",
                    "requestTime"=> $datetime,
                    "responseCode"=> "TA",
                    "taxpayerID"=> "1",
                    "tin"=> $tin,
                    "userName"=> "admin",
                    "version"=> "1.1.20191201",
                    "longitude"=> "116.397128",
                    "latitude"=> "39.916527",
                    "extendField"=> array(
                    "responseDateFormat"=> "yyyy/MM/dd",
                    "responseTimeFormat"=> "yyyy/MM/dd HH:mm:ss",
                    "referenceNo"=> "")
            ),
            "returnStateInfo"=>array(
             "returnCode"=> "",
                    "returnMessage"=> ""
            )
            ));
    }
}
