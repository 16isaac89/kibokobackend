<?php
namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Mail;
use Twilio\Rest\Client;

class HelperController extends Controller
{


public function notifyCustomer($details,$rider,$car){

    $sid = 'AC6ce424a355c707a1425b5a37ac8f3229';
    $token = 'ff6a915b4af0e7b2e46a35958955861f';
    $client = new Client($sid, $token);
    $data = array('rider'=>$rider,'car'=>$car);
Mail::send(['html'=>'bookingdets'], $data, function($message) use($details) {
    $message->to($details->email, $details->fullname)->subject
       ('Booking Status Changed:'.$details->tripttype);
    $message->from('info@amarihitch.co','Amari Hitch');
 });

 $message =  "Full Name:  " . $rider->fullname . "\r\n" .
 "Phone:  " . $rider->phone . "\r\n" .
 "ID Number:  " . $rider->id . "\r\n" . "Please check your booking email address for more information";
 $responsed = $client->messages
                  ->create("whatsapp:".$details->countrycode.$details->phone, // to
                           [
                               "from" => "whatsapp:+14155238886",
                               "body" => $message
                           ]
         );

}


}
