<?php

namespace App\Http\Controllers\Helper\Efris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTimeZone;
use DateTime;
use App\Http\Controllers\Helper\Efris\PostdataController;

class TaxPayerController extends Controller
{

    public function aes_encrypt($key, $plaintext){
        $encodedEncryptedData=base64_encode(openssl_encrypt($plaintext, "AES-128-ECB", $key,OPENSSL_RAW_DATA));
        return $encodedEncryptedData;
        }

        public function aes_decrypt($key, $plaintext){
        $decodedDecryptedData = openssl_decrypt($plaintext, "AES-128-ECB", $key,OPENSSL_RAW_DATA);
        return $decodedDecryptedData;
        }

      // GET TAXPAYER INFORMATION
      public function getTaxPayer($deviceno,$tin,$privatek,$aeskey,$tin2){
       // $url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
        $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
        $appId = "AP04";
        $brn = "";
        $dataExchangeId = "9230489223014123";
        $deviceMAC = "123";
        $deviceNo = $deviceno;
        $interfaceCode = "T119";
        $tin = $tin;
        $codeType = 1;
        $encryptCode = 1;
        $zipCode = 1;
        //Get the aes key from efris
        $decrypted_aeskey = $aeskey;
        //$decrypted_aeskey = "CA6PkrsNMny2KBAocf7zMw==";

        //Get local private key
        $privatekey = $privatek;
        $json = json_encode(
            [
            "tin"=>$tin2,
            "ninBrn"=>""
             ]
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);

        /*Encrypt JSON using AES*/
    $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

    /*Sign Encrypted Content*/
    openssl_sign($encryptedcontent, $signatureMe, $privatekey);

    /*Release private key*/
   // openssl_free_key($privatekey);

    /*Base64 Encode Signature*/
    $base64signature = base64_encode($signatureMe);

    //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
    $post_data =   (new PostdataController)->post_data2($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);

    // dd($post_data);
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
        $response = json_decode($json_response);
      //return $response;

    $data = $response->data;
    /*Get data*/
    $data_json = $data;
    $key = "content";
    $encryptedrespcontent = $data->content;
    $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));

    return json_decode($decryptedrescontent)->taxpayer;

    }
}
