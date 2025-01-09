<?php

namespace App\Http\Controllers\Helper\Efris;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\Efris\InvoiceController;
use App\Http\Controllers\Helper\Efris\PostdataController;
use DateTime;
use DateTimeZone;

class InvoiceController extends Controller
{
    public function aes_encrypt($key, $plaintext)
    {
        $encodedEncryptedData = base64_encode(openssl_encrypt($plaintext, "AES-128-ECB", $key, OPENSSL_RAW_DATA));
        return $encodedEncryptedData;
    }

    public function aes_decrypt($key, $plaintext)
    {
        $decodedDecryptedData = openssl_decrypt($plaintext, "AES-128-ECB", $key, OPENSSL_RAW_DATA);
        return $decodedDecryptedData;
    }

    public function saveInvoice($aeskey, $privatek, $tin, $deviceno, $goodsdetails, $taxDetails, $saleid, $total, $itemcount, $route, $dealerefris, $sumgross, $summarytotal, $taxamount, $customerdetails)
    {
       // $url = env("EFRIS_URL", "https://efrisws.ura.go.ug/ws/taapp/")."getInformation";
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
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        $now = new DateTime(null, new DateTimeZone('Africa/Nairobi'));
        $datetime = $now->format('Y-m-d H:i:s');
        $customer = $customerdetails;
        $buyertin = "";
        if ($customer->buyerType === "0" || $customer->buyerType === 0) {
            $buyertin = $customer->tin;
        } elseif (($customer->buyerType === "1" || $customer->buyerType === 1) && ($customer->tin !== "" || $customer->tin !== null)) {
            $buyertin = $customer->tin;
        } else {
            $buyertin = "";
        }
        $decrypted_aeskey = $aeskey;
        $json = json_encode(
            (Object) [
                "sellerDetails" => (Object) [
                    "tin" => $tin,
                    "ninBrn" => $dealerefris->nin,
                    "legalName" => $dealerefris->tradename,
                    "businessName" => $dealerefris->tradename,
                    "address" => $dealerefris->address,
                    "mobilePhone" => $dealerefris->phonenumber,
                    "linePhone" => "",
                    "emailAddress" => $dealerefris->email,
                    "placeOfBusiness" => $dealerefris->address,
                    //change every invoice upload
                    "referenceNo" => $saleid,
                ],
                "basicInformation" => (Object) [
                    "invoiceNo" => "",
                    "antifakeCode" => "",
                    "deviceNo" => $deviceno,
                    "issuedDate" => "",
                    "operator" => "URA",
                    "currency" => "UGX",
                    "oriInvoiceId" => "1",
                    "invoiceType" => "1",
                    "invoiceKind" => "1",
                    "dataSource" => "101",
                    "invoiceIndustryCode" => "101",
                    "isBatch" => "0",
                ],
                "buyerDetails" => (Object) [
                    "buyerTin" => $buyertin,
                    //"buyerTin"=>$customer->tin,
                    "buyerNinBrn" => "",
                    "buyerPassportNum" => "",
                    "buyerLegalName" => $customer->name,
                    "buyerBusinessName" => $customer->name,
                    "buyerAddress" => $customer->address,
                    "buyerEmail" => $customer->email,
                    "buyerMobilePhone" => $customer->phone,
                    "buyerLinePhone" => "",
                    "buyerPlaceOfBusi" => "",
                    //"buyerType"=>$customer->buyerType,
                    "buyerType" => $customer->buyerType === "1" || $customer->buyerType === 1 ? "1" : "0",
                    "buyerCitizenship" => "1",
                    "buyerSector" => "1",
                    //change every invoice upload
                    "buyerReferenceNo" => $saleid,
                ],
                "goodsDetails" => $goodsdetails,
                "taxDetails" => $taxDetails,
                //invoice summary
                "summary" => (Object) [
                    "netAmount" => round($summarytotal, 2),
                    "taxAmount" => floor($taxamount * 100) / 100,
                    "grossAmount" => $sumgross,
                    "itemCount" => $itemcount,
                    "modeCode" => "1",
                    "remarks" => "This is another remark test.",
                    "qrCode" => "",
                ],
                "payWay" => [
                    (Object) [
                        "paymentMode" => "101",
                        "paymentAmount" => $total,
                        "orderNumber" => 1,
                    ],
                    (Object) [
                        "paymentMode" => "102",
                        "paymentAmount" => $total,
                        "orderNumber" => "a",
                    ],
                ],
                "extend" => (Object) [
                    "reason" => "reason",
                    "reasonCode" => "102",
                ],
            ]
        );

        //dd($json);
        $encryptedcontent = $this->aes_encrypt(base64_decode($decrypted_aeskey), $json);

        /*Sign Encrypted Content*/
        openssl_sign($encryptedcontent, $signatureMe, $privatekey);

        /*Release private key*/
        // openssl_free_key($privatekey);

        /*Base64 Encode Signature*/
        $base64signature = base64_encode($signatureMe);
        //$post_data = $this->post_data($encryptedcontent,$base64signature,$codeType,$encryptCode,$zipCode,$deviceNo,$tin,$interfaceCode);
        $post_data = (new PostdataController)->post_data($encryptedcontent, $base64signature, $codeType, $encryptCode, $zipCode, $deviceNo, $tin, $interfaceCode);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        /*Get Response*/
        $json_response = curl_exec($curl);
//dd($json_response);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status != 200) {
            return (Object) array(
                'status' => 204,
            );
            //die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        } else {
            curl_close($curl);

            /*Decode response*/
            $response = json_decode($json_response, true);
            //dd($response,$taxDetails,$taxamount,$json);
            //return $response;
            // dd($response);

            $data = $response['data'];
            /*Get data*/
            $data_json = $data;
            $key = "content";
            $encryptedrespcontent = $data['content'];
            $respcode = $response;
            $decryptedrescontent = $this->aes_decrypt(base64_decode($decrypted_aeskey), base64_decode($encryptedrespcontent));
           // dd($decryptedrescontent);
            return (Object) array(
                'status' => 200,
                'data' => json_decode($decryptedrescontent),
                'datadec' => $decryptedrescontent,
                'respcode' => $respcode,
                "netAmount" => $summarytotal,
                'json' => $json,
                //'respmsg'=>$response->returnStateInfo->returnMessage
            );
        }
        //return base64_encode($decryptedrescontent);
    }
}
