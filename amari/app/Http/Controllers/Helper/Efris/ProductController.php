<?php

namespace App\Http\Controllers\Helper\Efris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTimeZone;
use DateTime;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\PostdataController;

class ProductController extends Controller
{
        public function aes_encrypt($key, $plaintext){
            $encodedEncryptedData=base64_encode(openssl_encrypt($plaintext, "AES-128-ECB", $key,OPENSSL_RAW_DATA));
            return $encodedEncryptedData;
            }

            public function aes_decrypt($key, $plaintext){
            $decodedDecryptedData = openssl_decrypt($plaintext, "AES-128-ECB", $key,OPENSSL_RAW_DATA);
            return $decodedDecryptedData;
            }
    public function saveProduct($item,$aeskey,$privatek,$tin,$deviceno){
        //dd($item,$aeskey,$privatek,$tin,$deviceno);
       //$url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
        $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
        $appId = "AP04";
        $brn = "";
        $dataExchangeId = "9230489223014123";
        $deviceMAC = "123";
        $deviceNo = $deviceno;
        $interfaceCode = "T130";
        $tin = $tin;
        $codeType = "1";
        $encryptCode = "2";
        $zipCode = "0";

        $privatekey = $privatek;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d H:i:s');

        $decrypted_aeskey = $aeskey;
        //operation code 101 save new product
        //operation code 102 save product stock
            $json = json_encode([
                (Object)[
                "operationType"=> "101",
                "goodsName"=> $item->name,
                "goodsCode"=> $item->code,
                "measureUnit"=> $item->unit,
                "unitPrice"=> $item->selling_price,
                "currency"=> "101",
                "commodityCategoryId"=>$item->efriscategorycode,
				//101 has excise tax 102 does not have
                "haveExciseTax"=> "102",
                //"exciseDutyCode"=> "LED010100",
                //"goodsTypeCode"=> "101",
                "exciseFlag"=> "1",
                "description"=> "1",
                "stockPrewarning"=> "10",
                "pieceMeasureUnit"=> "",
                "havePieceUnit"=> "102",
                "pieceUnitPrice"=> "",
                "packageScaledValue"=> "",
                "pieceScaledValue"=> "",
            ],
        ]);
           // dd($json);
    $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

    /*Sign Encrypted Content*/
    openssl_sign($encryptedcontent, $signatureMe, $privatekey);

    /*Release private key*/
    //openssl_free_key($privatekey);

    /*Base64 Encode Signature*/
    $base64signature = base64_encode($signatureMe);

     //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
    $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
        //var_dump($post_data);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        /*Get Response*/
        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 200 ) {
            return (Object)["status"=>0,'message'=>curl_error($curl)];
            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }


        curl_close($curl);

        /*Decode response*/
        $response = json_decode($json_response, true);
        //dd($response);
        $data = $response['data'];
        /*Get data*/
        $data_json = $data;
        $key = "content";
        $encryptedrespcontent = $data['content'];
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
  $status = $response['returnStateInfo']['returnCode'];
        $msg = $response['returnStateInfo']['returnMessage'];
        return (Object)['status'=>$status,'message'=>$response,'data'=>$decryptedrescontent,'msg'=>$msg];
        //return base64_encode($decryptedrescontent)
    }



// add product stock
    public function restockProduct($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier,$purchase_type,$dealerproduct){
        //$url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
        $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
        $appId = "AP04";
        $brn = "";
        $dataExchangeId = "9230489223014123";
        $deviceMAC = "123";
        $deviceNo = $deviceno;
        $interfaceCode = "T131";
        $tin = $tin;
        $codeType = "1";
        $encryptCode = "1";
        $zipCode = "0";
 $privatekey = $privatek;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d');

        $decrypted_aeskey = $aeskey;
        //operation code 101 save new product
        //operation code 102 save product stock
            $json = json_encode(
                (Object)[
                        "goodsStockIn"=> (Object)[

                            "operationType"=> "101",
                            //"supplierTin"=> $supplier->tin,
                            "supplierTin"=> "1011030099",
                            // "supplierName"=> $supplier->name,
                            "supplierName"=> "Clear Way Services",
                            "adjustType"=> "",
                            "remarks"=> "Increase inventory",
                            "stockInDate"=> $datetime,
                            "stockInType"=> $purchase_type,
                            "productionBatchNo"=> "",
                            "productionDate"=> "",
                            "branchId"=> "",
                            "invoiceNo"=> "",
                            "isCheckBatchNo"=> "0"

                        ],
                                "goodsStockInItem"=> [
                                        (Object)[
                                "commodityGoodsId"=> "",
                                "goodsCode"=> $item->efriscategorycode,
                                "measureUnit"=>$item->unit,
                                "quantity"=> $quantity,
                                "unitPrice"=> $item->selling_price
                                        ]
                                ]
            ],
        );
            // dd($json);
    $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

    /*Sign Encrypted Content*/
    openssl_sign($encryptedcontent, $signatureMe, $privatekey);

    /*Release private key*/
    //openssl_free_key($privatekey);

    /*Base64 Encode Signature*/
    $base64signature = base64_encode($signatureMe);
    // $post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
    $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
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
dd($response);
        $data = $response['data'];
        /*Get data*/
        $data_json = $data;
        $key = "content";
        $encryptedrespcontent = $data['content'];
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
        $dealerproduct->increment('stock',$quantity);
       // dd($response);
        //dd((Object)['status'=>1,'message'=>$response,'data'=>$decryptedrescontent]);
        return (Object)['status'=>1,'message'=>$response,'data'=>$decryptedrescontent];
        //return $decryptedrescontent;
    }



    ///save product opening stock
    public function addproductStock($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$supplier,$dealerproduct,$purchase_type){
       // dd($item);

        //$url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
        $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
        $appId = "AP04";
        $brn = "";
        $dataExchangeId = "9230489223014123";
        $deviceMAC = "123";
        $deviceNo = $deviceno;
        $interfaceCode = "T131";
        $tin = $tin;
        $codeType = "1";
        $encryptCode = "1";
        $zipCode = "0";
 $privatekey = $privatek;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d');

        $decrypted_aeskey = $aeskey;
        //operation code 101 save new product
        //operation code 102 save product stock
            $json = json_encode(
                (Object)[
                        "goodsStockIn"=> (Object)[
                                "operationType"=> "101",
                            //"supplierTin"=> $supplier->tin,
                            "supplierTin"=> "1011030099",
                            // "supplierName"=> $supplier->name,
                            "supplierName"=> "Clear Way Services",
                            "adjustType"=> "",
                            "remarks"=> "Increase inventory",
                            "stockInDate"=> $datetime,
                            "stockInType"=> $purchase_type,
                            "productionBatchNo"=> "",
                            "productionDate"=> "",
                            "branchId"=> "",
                            "invoiceNo"=> "",
                            "isCheckBatchNo"=> "0"
                        ],
                                "goodsStockInItem"=> [
                                        (Object)[
                                "commodityGoodsId"=> "",
                                "goodsCode"=> $item->code,
                                "measureUnit"=>$item->unit,
                                "quantity"=> $quantity,
                                "unitPrice"=> $item->selling_price
                                        ]
                                ]
            ],
        );
            // dd($json);
    $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

    /*Sign Encrypted Content*/
    openssl_sign($encryptedcontent, $signatureMe, $privatekey);

    /*Release private key*/
   // openssl_free_key($privatekey);

    /*Base64 Encode Signature*/
    $base64signature = base64_encode($signatureMe);
    // $post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
    $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        /*Get Response*/
        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 200 ) {

            $error = "Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl);
            return (Object)['status'=>0,'error'=>$error];
        }


        curl_close($curl);

        /*Decode response*/
        $response = json_decode($json_response, true);
     // dd($response);
        $data = $response['data'];
        /*Get data*/
        $data_json = $data;
        $key = "content";
        $encryptedrespcontent = $data['content'];
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
        $dealerproduct->increment('stock',$quantity);
        $status = $response['returnStateInfo']['returnCode'];
        //dd($status);
       // dd($decryptedrescontent,$response);
        return (Object)['status'=>1,'message'=>$response,'data'=>$decryptedrescontent];
        //return $decryptedrescontent;
    }



    ///save product opening stock
    public function stockReduction($item,$aeskey,$privatek,$tin,$deviceno,$quantity,$remarks,
    $reason,$dealer_product){
        $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
        $appId = "AP04";
        $brn = "";
        $dataExchangeId = "9230489223014123";
        $deviceMAC = "123";
        $deviceNo = $deviceno;
        $interfaceCode = "T131";
        $tin = $tin;
        $codeType = "1";
        $encryptCode = "1";
        $zipCode = "0";
        $privatekey = $privatek;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d');

        $decrypted_aeskey = $aeskey;
        //operation code 101 save new product
        //operation code 102 save product stock
            $json = json_encode(
                (Object)[
                        "goodsStockIn"=> (Object)[
                                "operationType"=>"102",
                                "supplierTin"=> "",
                                "supplierName"=> "",
                                "adjustType"=> $reason,
                                "remarks"=> $remarks,
                                "stockInDate"=> $datetime,
                                "stockInType"=> "",
                                "productionBatchNo"=> "",
                                "productionDate"=> "",
                                "branchId"=> "",
                                "invoiceNo"=> "",
                                "isCheckBatchNo"=> "0"
                        ],
                                "goodsStockInItem"=> [
                                        (Object)[
                                "commodityGoodsId"=> "",
                                "goodsCode"=> $dealer_product->product->code,
                                "measureUnit"=>$dealer_product->product->unit,
                                "quantity"=> $quantity,
                                "unitPrice"=> $dealer_product->product->selling_price
                                        ]
                                ]
            ],
        );
            // dd($json,$json3);
    $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

    /*Sign Encrypted Content*/
    openssl_sign($encryptedcontent, $signatureMe, $privatekey);

    /*Release private key*/
   // openssl_free_key($privatekey);

    /*Base64 Encode Signature*/
    $base64signature = base64_encode($signatureMe);
    // $post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
    $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        /*Get Response*/
        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 200 ) {

            $error = "Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl);
            return (Object)['status'=>0,'error'=>$error];
        }


        curl_close($curl);

        /*Decode response*/
        $response = json_decode($json_response, true);
      //dd($response);
        $data = $response['data'];
        /*Get data*/
        $data_json = $data;
        $key = "content";
        $encryptedrespcontent = $data['content'];
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
        //$item->increment('stock',$quantity);
        $status = $response['returnStateInfo']['returnCode'];
        //dd($status);
        return (Object)['status'=>1,'message'=>$response,'data'=>$decryptedrescontent,'json'=>$json];
        //return $decryptedrescontent;
    }

}
