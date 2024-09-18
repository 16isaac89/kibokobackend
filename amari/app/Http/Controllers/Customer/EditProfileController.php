<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Hash;
use App\Models\Customer;



class EditProfileController extends Controller
{

    public function profileChange(Request $request)
    {
        //dd($request->all());
        $fullname = $request->fullname;
        $email = $request->email;
        $phone = $request->phone;
        $home = $request->home;
        $office = $request->office;
        $username = $request->username;
        $userId = Auth::guard('customers')->user()->id;
        $count = count(Booking::where('customer_id',$userId)->get());
        $completed = count(Booking::where('customer_id',$userId)->where('status','completed')->get());
        $cancelled = count(Booking::where('customer_id',$userId)->where('status','cancelled')->get());
        $upcoming = count(Booking::where('customer_id',$userId)->where('status','received')->get());

        $validator = Validator::make($request->all(),
                    [
                'email' => [
                            Rule::unique('customers')->ignore(Auth::guard('customers')->user()->id),
                        ],
                'phone' => [
                            Rule::unique('customers')->ignore(Auth::guard('customers')->user()->id),
                        ],
                    ]);

                    if ($validator->fails()) {
                        $message = Arr::first(Arr::flatten($validator->messages()->get('*')));
                       // Alert::toast('OOPS', `$message`);
                        return back()->with('message', $message);
                        // dd($message);
                        // return response()->json(['error'=>$message], 401);
                        }
             $user = Customer::find(Auth::guard('customers')->user()->id);
             $user->update([
                 'fullname'=> $fullname == null ? Auth::guard('customers')->user()->fullname : $fullname,
                 'phone'=> $phone == null ? Auth::guard('customers')->user()->phone : $phone,
                'email'=> $email == null ? Auth::guard('customers')->user()->email : $email,
                'home'=> $home == null ? Auth::guard('customers')->user()->home : $home,
                'office'=> $office == null ? Auth::guard('customers')->user()->office : $office,
                'username'=> $username == null ? Auth::guard('customers')->user()->username : $username,
             ]);
             Alert::success('Success', 'Profile Has been Successfully Changed');
             return view("customer.profile");
    }


    public function pwdChange(Request $request)
    {
        $value = $request->oldpassword;
        $userId = Auth::guard('customers')->user()->id;
        $count = count(Booking::where('customer_id',$userId)->get());
        $completed = count(Booking::where('customer_id',$userId)->where('status','completed')->get());
        $cancelled = count(Booking::where('customer_id',$userId)->where('status','cancelled')->get());
        $upcoming = count(Booking::where('customer_id',$userId)->where('status','received')->get());

             $checkpwd = Hash::check($value, Auth::guard('customers')->user()->password);
             if($checkpwd == false){
                Alert::error('Error', 'Your old password is incorrect');
                return view('customer.profile',['count'=>$count,'completed'=>$completed,'cancelled'=>$cancelled,'upcoming'=>$upcoming]);
             }
             Customer::find(Auth::guard('customers')->user()->id)->update(['password'=> Hash::make($request->new_password)]);
             Alert::success('Success', 'Password Has been Successfully Changed');
             return view('customer.profile',['count'=>$count,'completed'=>$completed,'cancelled'=>$cancelled,'upcoming'=>$upcoming]);

    }





}
