<?php

namespace App\Http\Controllers\Helper\Efris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTimeZone;
use DateTime;
use App\Http\Controllers\Helper\Efris\PostdataController;

class KeysController extends Controller
{

        public function getPrivateKey($keypath,$keypwd){
            /*Get Private Key*/
            //$prikey = asset("/keys/profocus/profocus.com.p12");
            $prikey = $keypath;
            // $pubkey = asset("/keys/digital.com.cer");
           // $pwd = "XMKSJ";
            $pwd = $keypwd;
            $certs = array();
           // dd($prikey,$pwd);
            $pkcs12 = file_get_contents($prikey);
            $privkeyopen = openssl_pkcs12_read($pkcs12,$certs,$pwd);
            $privkey = $certs['pkey'];  //private key
            //dd($privkey);
            return openssl_pkey_get_private($privkey, $pwd);
        }


    //GET AES KEY
       public function getAesKey($tin,$deviceno,$privatek){
        $url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
       // $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
            $appId = "AP04";
            $brn = "";
            $dataExchangeId = "9230489223014123";
            $deviceMAC = "123";
            $deviceNo = $deviceno;
            $interfaceCode = "T104";
            $tin = $tin;
            $codeType = "0";
            $encryptCode = "0";
            $zipCode = "0";
            $encryptedcontent = "";
            $base64signature = "";
            $privatekey = $privatek;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
            $datetime = $now->format('Y-m-d H:i:s');

            $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);

        //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);

         /*Post data*/
         curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
     /*Get Response*/
         $json_response = curl_exec($curl);
         $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
         if ( $status != 200 ) {
             die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
         }
         curl_close($curl);
         /*Decode response*/
         $response = json_decode($json_response, true);
          //dd($response);
         if($response['returnStateInfo']['returnCode']=== "00"){
            $key = "data";
         $data = $response['data'];
         /*Get data*/
         $data_json = $data;
        $key = "content";
         $content = $data_json[$key];
         //echo $content;
         //dd($content);
         $decode_content=base64_decode($content);
         //dd($decode_content);
         $encrypted_aeskey = json_decode($decode_content,true)['passowrdDes'];
        // dd($encrypted_aeskey,$privatekey);
        openssl_private_decrypt(base64_decode($encrypted_aeskey), $decrypted_aeskey,$privatekey );
        // dd($decrypted_aeskey);
        //  if ($success) {
        //     echo "Decryption successful: " . $decrypted_aeskey;
        // } else {
        //     echo "Decryption failed: " . openssl_error_string();
        // }
       //  dd($decrypted_aeskey);
         return $decrypted_aeskey;

         }else{
            return $response;
         }


        }

}
