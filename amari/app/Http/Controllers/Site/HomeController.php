<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use Carbon\Carbon;
use Validator;
use Mail;
use App\Models\ContactUs;


class HomeController extends Controller
{
public function index(){
    return view('home.site');
}
public function message(Request $request){
ContactUs::create([
    'name'=>$request->name,
    'email'=>$request->email,
    'phone'=>$request->phone,
    'message'=>$request->message,
]);
return redirect()->back()->with('success','Message sent successfully.');
}

}
