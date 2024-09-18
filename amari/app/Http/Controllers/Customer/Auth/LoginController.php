<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{

public function index(){
    return view('customer.auth.login');
}
public function login(Request $request){
    //dd(url()->current());
    //dd($request->all());
    $customer = 
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    if (Auth::guard('customers')->attempt($credentials)) {
        return redirect()->route('customer.dashboard.index')
        // ->intended()
         ->with('status','You have logged in!');
    }
    return redirect()->route("customer.login.view")->with('status','Opps! You have entered invalid credentials');



}

public function signout() {
    Session::flush();
    Auth::logout();

    return redirect()->route("customer.login.view");
}

}
