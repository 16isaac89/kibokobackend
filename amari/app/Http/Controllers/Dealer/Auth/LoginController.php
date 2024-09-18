<?php

namespace App\Http\Controllers\Dealer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{

public function index(){
    return view('dealer.auth.login');
}
public function login(Request $request){
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('username', 'password');
    if (Auth::guard('dealer')->attempt($credentials)) {
        return redirect()->route('dashboard.home')
         ->with('status','You have logged in!');
    }
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');



}

public function signout() {
    Session::flush();
    Auth::logout();
    return redirect()->route("dealer.login.view");
}

}
