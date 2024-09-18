<?php

namespace App\Http\Controllers\Helper\Efris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTimeZone;
use DateTime;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\PostdataController;

class NotesController extends Controller
{

    public function aes_encrypt($key, $plaintext){
        $encodedEncryptedData=base64_encode(openssl_encrypt($plaintext, "AES-128-ECB", $key,OPENSSL_RAW_DATA));
        return $encodedEncryptedData;
        }

        public function aes_decrypt($key, $plaintext){
        $decodedDecryptedData = openssl_decrypt($plaintext, "AES-128-ECB", $key,OPENSSL_RAW_DATA);
        return $decodedDecryptedData;
        }

    public function creditnote($deviceno,$tin,$privatek, $aeskey,$reason,$details,$doc,$itemcount,$reasoncode,$dealerefris){
//dd($doc);
$url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
        //$url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
        $appId = "AP04";
        $brn = "";
        $dataExchangeId = "9230489223014123";
        $deviceMAC = "123";
        $deviceNo = $deviceno;
        $interfaceCode = "T110";
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
            $json = json_encode(
                (Object)[
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
                    "oriInvoiceId"=> $doc->inv_id,
                    "oriInvoiceNo"=> $doc->inv_no,
                    "reasonCode"=> $reasoncode,
                    "reason"=> $reason,
                    "applicationTime"=> "2019-06-15 15:02:02",
                    //credit 101 debit 102
                    "invoiceApplyCategoryCode"=> "101",
                    "currency"=> "UGX",
                    "contactName"=> "1",
                    "contactMobileNum"=> "1",
                    "contactEmail"=> $dealerefris->email,
                    "source"=> "101",
                    "remarks"=> "Remarks",
                    "sellersReferenceNo"=> "00000000012",
                    "sellerDetails"=> (Object)[
                        "tin"=> $tin,
                        "deviceNo"=> $deviceno,
                        "ninBrn"=> $brn,
                        "legalName"=> $dealerefris->tradename,
                        "businessName"=> $dealerefris->tradename,
                        "address"=> $dealerefris->address,
                        "mobilePhone"=> $dealerefris->phonenumber,
                        "linePhone"=> "",
                        "emailAddress"=> $dealerefris->email,
                        "placeOfBusiness"=> $dealerefris->address,
                        "referenceNo"=> "00000000024"
                        ],

                    "goodsDetails"=> $details->goodsdetails,
                    "taxDetails"=> $details->taxdetails,
                    "summary"=> (Object)[
                        "netAmount"=> floor(($details->summarytotal)*100)/100,
                        "taxAmount"=> $details->taxamount,
                        "grossAmount"=> $details->sumgross,
                        "itemCount"=> $itemcount,
                        "modeCode"=> "1",
                        "remarks"=> "This is another remark test.",
                        "qrCode"=> ""
                    ],
                        "payWay"=> [
                            (Object)[
                        "paymentMode"=> "101",
                        "paymentAmount"=> "686.45",
                        "orderNumber"=> "a"
                            ],
                        (Object)[
                        "paymentMode"=> "102",
                        "paymentAmount"=> "686.45",
                        "orderNumber"=> "a"
                        ]
                    ],
                         "buyerDetails"=> (Object)[
                            "buyerTin"=> "",
                            "buyerNinBrn"=> "",
                            "buyerPassportNum"=> "",
                            "buyerLegalName"=> "zhangsan",
                            "buyerBusinessName"=> "lisi",
                            "buyerAddress"=> "beijin",
                            "buyerEmail"=> "123456@163.com",
                            "buyerMobilePhone"=> "15501234567",
                            "buyerLinePhone"=> "010-6689666",
                            "buyerPlaceOfBusi"=> "beijin",
                            "buyerType"=> "1",
                            "buyerCitizenship"=> "1",
                            "buyerSector"=> "1",
                            "buyerReferenceNo"=> "00000000007"
                         ],
                        "importServicesSeller"=> (Object)[
                        "importBusinessName"=> "lisi",
                        "importEmailAddress"=>"123456@163.com",
                        "importContactNumber"=> "15501234567",
                        "importAddress"=> "beijin",
                        "importInvoiceDate"=> "2020-09-05",
                        "importAttachmentName"=> "test",
                        "importAttachmentContent"=>
                        "MIIDFjCCAf6gAwIBAgIRAKPGAol9CEdpkIoFa8huM6zfj1WEBRxteoo6PH46un4FGj
                        4N6ioIGzVr9G40uhQGdm16ZU+q44XjW2oUnI9w="
                        ],
                        "basicInformation"=> (Object)[
                        "operator"=> "aisino",
                      //Aplying for credit note
                        "invoiceType"=> "2",
                        "invoiceIndustryCode"=> "104",
                        "branchId"=> "207300908813650312",
                        "deviceNo"=>$deviceNo,
                        "currency"=> "UGX",
                        ]

                ]



        );

                $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);
 //dd($json);
    /*Sign Encrypted Content*/
    openssl_sign($encryptedcontent, $signatureMe, $privatekey);

    /*Release private key*/
    //openssl_free_key($privatekey);

    /*Base64 Encode Signature*/
    $base64signature = base64_encode($signatureMe);

     //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
     $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
     //var_dump($post_data);
    // $post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        /*Get Response*/
        $json_response = curl_exec($curl);
    //dd($json_response);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 200 ) {
            return (Object)array(
                'status'=>204,
            );
            //die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }else{
        curl_close($curl);

        /*Decode response*/
        $response = json_decode($json_response, true);

        $data = $response['data'];
        /*Get data*/
        $data_json = $data;
        $key = "content";
        $encryptedrespcontent = $data['content'];
        $respcode = $response;
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
       //dd($json_response,$decryptedrescontent);
        return (Object)array(
            'status'=>200,
            'data'=>$decryptedrescontent,
            'respcode'=>$respcode,
            //'respmsg'=>$response->returnStateInfo->returnMessage
        );
    }
    }


    public function debitnote($deviceno,$tin,$privatek, $aeskey,$details,$doc,$itemcount,$invid,$dealerefris,$saleid,$total,$route){
        $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
        $appId = "AP04";
        $brn = "";
        $dataExchangeId = "9230489223014123";
        $deviceMAC = "123";
        $deviceNo = $deviceno;
        $interfaceCode = "T109";
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
        $json = json_encode(
            (Object)[
                "sellerDetails"=> (Object)[
                    "tin"=> $tin,
                    "ninBrn"=> "201905081705",
                    "legalName"=> $dealerefris->tradename,
                    "businessName"=> $dealerefris->tradename,
                    "address"=> $dealerefris->address,
                    "mobilePhone"=> $dealerefris->phonenumber,
                    "linePhone"=> "",
                    "emailAddress"=> $dealerefris->email,
                    "placeOfBusiness"=> $dealerefris->address,
                    //change every invoice upload
                    "referenceNo"=> $saleid
                ],
                "basicInformation"=> (Object)[
                "invoiceNo"=> "",
                "antifakeCode"=> "",
                "deviceNo"=> $deviceno,
                "issuedDate"=> "",
                "operator"=> "URA",
                "currency"=> "UGX",
                "oriInvoiceId"=> $invid,
                "invoiceType"=> "4",
                "invoiceKind"=> "1",
                "dataSource"=> "101",
                "invoiceIndustryCode"=> "102",
                "isBatch"=> "0"
                ],
                "buyerDetails"=> (Object)[
                "buyerTin"=> "",
                "buyerNinBrn"=> "",
                "buyerPassportNum"=> "",
                "buyerLegalName"=> $route->name,
                "buyerBusinessName"=> $route->name,
                "buyerAddress"=> "",
                "buyerEmail"=> "",
                "buyerMobilePhone"=> $route->phone,
                "buyerLinePhone"=> "",
                "buyerPlaceOfBusi"=> "",
                "buyerType"=> "1",
                "buyerCitizenship"=> "1",
                "buyerSector"=> "1",
                //change every invoice upload
                "buyerReferenceNo"=> $saleid
                ],
                "goodsDetails"=> $details->goodsdetails,
                "taxDetails"=> $details->taxdetails,
                //invoice summary
                "summary"=> (Object)[
                "netAmount"=> $details->summarytotal,
                "taxAmount"=> $details->taxamount,
                "grossAmount"=> $details->sumgross,
                "itemCount"=> $itemcount,
                "modeCode"=> "1",
                "remarks"=> "This is another remark test.",
                "qrCode"=> ""
                ],
                "payWay"=> [
                    (Object)[
                "paymentMode"=> "101",
                "paymentAmount"=> $total,
                "orderNumber"=> 1
                    ],
                    (Object)[
                "paymentMode"=> "102",
                "paymentAmount"=> $total,
                "orderNumber"=> "a"
                ]
            ],
                "extend"=> (Object)[
                "reason"=> "reason",
                "reasonCode"=> "102"
                ]
        ]
    );

                $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

    /*Sign Encrypted Content*/
    openssl_sign($encryptedcontent, $signatureMe, $privatekey);

    /*Release private key*/
    openssl_free_key($privatekey);

    /*Base64 Encode Signature*/
    $base64signature = base64_encode($signatureMe);
    //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
    $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        /*Get Response*/
        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 200 ) {
            return (Object)array(
                'status'=>204,
            );
            //die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }else{
        curl_close($curl);

        /*Decode response*/
        $response = json_decode($json_response, true);

        $data = $response['data'];
        /*Get data*/
        $data_json = $data;
        $key = "content";
        $encryptedrespcontent = $data['content'];
        $respcode = $response;
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));

        return (Object)array(
            'status'=>200,
            'data'=>json_decode($decryptedrescontent),
            'respcode'=>$respcode,
           // "netAmount"=> $summarytotal,
            //'respmsg'=>$response->returnStateInfo->returnMessage
        );
    }

    }


    //GET Credit note status
    public function getstatus($tin,$deviceno,$privatek,$aeskey,$noteid,$inv_no,$from_date,$to_date){

        $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
            $appId = "AP04";
            $brn = "";
            $dataExchangeId = "9230489223014123";
            $deviceMAC = "123";
            $deviceNo = $deviceno;
            $interfaceCode = "T111";
            $tin = $tin;
            $codeType = "1";
            $encryptCode = "1";
            $zipCode = "1";
        $decrypted_aeskey = $aeskey;
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d H:i:s');
        $json = json_encode(
            [

                "referenceNo"=> $noteid,
"oriInvoiceNo"=> "",
"invoiceNo"=> "",
"combineKeywords"=> "",
"approveStatus"=> "101,102,103,104",
"queryType"=> "1",
"invoiceApplyCategoryCode"=> "101",
"startDate"=> "2024-04-08",
"endDate"=> "2024-04-09",
"pageNo"=> "1",
"pageSize"=> "10",


                // "referenceNo"=> $noteid,
                // "oriInvoiceNo"=> $inv_no,
                // "invoiceNo"=> $inv_no,
                // "combineKeywords"=> "11111",
                // "approveStatus"=> "101,102,103,104",
                // "queryType"=> "1",
                // "invoiceApplyCategoryCode"=> "1",

                // "pageNo"=> "1",
                // "pageSize"=>"10" ,
                // "creditNoteType"=> "1"

             ]
        );

            $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

            $privatekey = $privatek;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
            $datetime = $now->format('Y-m-d H:i:s');

            $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

            /*Sign Encrypted Content*/
            openssl_sign($encryptedcontent, $signatureMe, $privatekey);

            /*Release private key*/
            //openssl_free_key($privatekey);

            /*Base64 Encode Signature*/
            $base64signature = base64_encode($signatureMe);
            //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
            $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);

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

        $data = $response['data'];
        /*Get data*/
        $data_json = $data;
        $key = "content";
        $encryptedrespcontent = $data['content'];
        $respcode = $response;
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));

        $decoded = json_decode($decryptedrescontent);
       // dd($decryptedrescontent);
        //  dd($decoded->records[0]);

         if($response['returnStateInfo']['returnCode']=== "00"){

         return (Object)array(
            'status'=>200,
            'data'=>$decoded->records,
        );

         }else{
            return (Object)array(
                'status'=>501,
                'data'=>$decoded->records,
            );
         }
        }





        public function creditnotecancel($deviceno,$tin,$privatek,$aeskey,$invoiceid,$invoiceno,
        $invoiceApplyCategoryCode,$reasonCode,$reason,$from_date,$to_date,$noteid){
            $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
            $appId = "AP04";
            $brn = "";
            $dataExchangeId = "9230489223014123";
            $deviceMAC = "123";
            $deviceNo = $deviceno;
            $interfaceCode = "T114";
            $tin = $tin;
            $codeType = "0";
            $encryptCode = "0";
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

            $json = json_encode(
                [
    "oriInvoiceId"=> $invoiceid,
    "invoiceNo"=> $invoiceno,
    "reason"=> "reason",
    "reasonCode"=> "102",
    "invoiceApplyCategoryCode"=> "104"

                 ]
            );

            //dd($json);
        $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

        /*Sign Encrypted Content*/
        openssl_sign($encryptedcontent, $signatureMe, $privatekey);

        /*Release private key*/
        //openssl_free_key($privatekey);

        /*Base64 Encode Signature*/
        $base64signature = base64_encode($signatureMe);

         //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
         $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
         //dd($post_data);
        // $post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

            /*Get Response*/
            $json_response = curl_exec($curl);
        //   dd($json_response);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ( $status != 200 ) {
                return (Object)array(
                    'status'=>204,
                );
                //die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
            }
            curl_close($curl);

            /*Decode response*/
            $response = json_decode($json_response, true);
            $data = $response['data'];
            /*Get data*/
            $data_json = $data;
            $key = "content";
            $encryptedrespcontent = $data['content'];
            $respcode = $response;
            $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
// dd($decryptedrescontent);

            // $data = $response['data'];
            // /*Get data*/
            // $data_json = $data;
            // $key = "content";
            // $encryptedrespcontent = $data['content'];
            // $respcode = $response;
            // $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
            return (Object)array(
                'status'=>200,
                'data'=>$decryptedrescontent,
                'respcode'=>$respcode,
                //'respmsg'=>$response->returnStateInfo->returnMessage
            );

        }



        //GET Credit note status
    public function getcreditnotedetails($tin,$deviceno,$privatek,$aeskey,$noteid){

        $url = "https://efristest.ura.go.ug/efrisws/ws/taapp/getInformation";
            $appId = "AP04";
            $brn = "";
            $dataExchangeId = "9230489223014123";
            $deviceMAC = "123";
            $deviceNo = $deviceno;
            $interfaceCode = "T108";
            $tin = $tin;
            $codeType = "1";
            $encryptCode = "1";
            $zipCode = "1";
        $decrypted_aeskey = $aeskey;
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d H:i:s');
        $json = json_encode(
            [

                "invoiceNo"=> $noteid,


             ]
        );

            $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

            $privatekey = $privatek;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
            $datetime = $now->format('Y-m-d H:i:s');

            $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

            /*Sign Encrypted Content*/
            openssl_sign($encryptedcontent, $signatureMe, $privatekey);

            /*Release private key*/
            //openssl_free_key($privatekey);

            /*Base64 Encode Signature*/
            $base64signature = base64_encode($signatureMe);
            //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
            $post_data =   (new PostdataController)->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);

         /*Post data*/
         curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
     /*Get Response*/
         $json_response = curl_exec($curl);


        // dd($json_response,$json);
         $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
         if ( $status != 200 ) {
             die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
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
        $respcode = $response;
        $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));

        $decoded = json_decode($decryptedrescontent);
        //  dd($decoded->records[0]);
         if($response['returnStateInfo']['returnCode']=== "00"){

         return (Object)array(
            'status'=>200,
            'data'=>$decoded,
        );

         }else{
            return (Object)array(
                'status'=>501,

            );
         }
        }

}
