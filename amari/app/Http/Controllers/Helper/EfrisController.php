<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTimeZone;
use DateTime;
use App\Models\DealerProduct; 
use App\Http\Controllers\Helper\Efris\PostdataController;

class EfrisController extends Controller
{

        public function getPrivateKey(){
                /*Get Private Key*/
                $prikey = asset("/keys/profocus/profocus.com.p12");
                //$prikey = $keypath;
                // $pubkey = asset("/keys/digital.com.cer");
               $pwd = "PFCS_HJS";
               // $pwd = $keypwd;
                $certs = array();
                $pkcs12 = file_get_contents($prikey);
                $privkeyopen = openssl_pkcs12_read($pkcs12,$certs,$pwd);
                $privkey = $certs['pkey'];  //private key
           
                return openssl_pkey_get_private($privkey, $pwd);
            }  

            //GET AES KEY
       public function getAesKey(){
        $url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
        //$url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
            $appId = "AP04";
            $brn = "";
            $dataExchangeId = "9230489223014123";
            $deviceMAC = "123";
            $deviceNo = "1000089262_01";
            $interfaceCode = "T104";
            $tin = "1000089262";
            $codeType = "0";
            $encryptCode = "0";
            $zipCode = "0";
            $encryptedcontent = "";
            $base64signature = "";


     $privatekey = $this->getPrivateKey();


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
                
         $key = "data";        
         $data = $response['data'];       
         /*Get data*/
         $data_json = $data;                
        $key = "content";
         $content = $data_json[$key];
         //echo $content;
         $decode_content=base64_decode($content);
         $encrypted_aeskey = json_decode($decode_content,true)['passowrdDes'];
         openssl_private_decrypt(base64_decode($encrypted_aeskey), $decrypted_aeskey, $privatekey );
         return $decrypted_aeskey;
        }


        public function aes_encrypt($key, $plaintext){
                $encodedEncryptedData=base64_encode(openssl_encrypt($plaintext, "AES-128-ECB", $key,OPENSSL_RAW_DATA));
                return $encodedEncryptedData;
                }
                
                public function aes_decrypt($key, $plaintext){
                $decodedDecryptedData=openssl_decrypt($plaintext, "AES-128-ECB", $key,OPENSSL_RAW_DATA);
                return $decodedDecryptedData;
                }
        
              // GET TAXPAYER INFORMATION
              public function getTaxPayer(){
                $url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
                //$url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
                $appId = "AP04";
                $brn = "";
                $dataExchangeId = "9230489223014123";
                $deviceMAC = "123";
                $deviceNo = "1000089262_01";
                $interfaceCode = "T119";
                $tin = "1000089262";
                $codeType = 1;
                $encryptCode = 1;
                $zipCode = 0;
                //Get the aes key from efris
                $decrypted_aeskey = $this->getAesKey();
                //$decrypted_aeskey = "CA6PkrsNMny2KBAocf7zMw==";
        
                //Get local private key
                $privatekey = $this->getPrivateKey();
        
               
        
        
                $json = json_encode(
                    [
                    "tin"=>$tin,
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
            openssl_free_key($privatekey);
            
            /*Base64 Encode Signature*/
            $base64signature = base64_encode($signatureMe);
        
            //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
            $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
                //var_dump($post_data);
                
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
       $encryptedrespcontent = json_encode($response->data->content);
      // dd(base64_encode($encryptedrespcontent));
       
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
        dd(json_decode($decryptedrescontent)->taxpayer->address);
        //return json_encode(base64_encode($decryptedrescontent),True);
      //  return base64_encode($decryptedrescontent->taxpayer);
            }

              

        
}
