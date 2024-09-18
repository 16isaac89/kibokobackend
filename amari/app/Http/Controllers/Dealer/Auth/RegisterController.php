<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use App\Models\Customer;
use Hash;

class RegisterController extends Controller
{

public function index(){
    return view('customer.auth.register');
}
public function register(Request $request) {
    $validator = Validator::make($request->all(),
                [
                'fullname' => 'required',
                'email' => 'required|email|unique:customers,email',
                'password' => 'min:6|required_with:c_password',
                'phone' => 'required|unique:customers,phone',
                // 'c_password' => 'required|same:password',
                ]);
    if ($validator->fails()) {
        $errors = $validator->errors();
        return redirect()->route('customer.register')->with('errors', $errors);
       // return response()->json(['error'=>$validator->errors()], 401);
        }
    $data = $request->all();
    Customer::create([
        'fullname' => $data['fullname'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'password' => Hash::make($data['password'])
      ]);
      //Alert::success('Success', 'Account Has been created successfully Please login');
      return redirect()->route("customer.login.view");
    }


}
