<?php

namespace App\Http\Controllers\dealer\auth;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DealerRole;
use App\Models\Van;
use Auth;
use Illuminate\Http\Request;
use Hash;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('dealer')->user();
        $user ->load('dealerroles','branch');
       // dd($user);
        $vans = Van::where('dealer_id',$user->dealer_id)->get();
        $roles = DealerRole::where('dealer_id',$user->dealer_id)
        ->orWhere('dealer_id',0)
            ->get();
        $branches = Branch::where('dealer_id',$user->dealer_id)->get();

        return view('dealer.auth.profile',compact('user','roles','vans','branches'));
    }
    public function changepassword(){
        dd(request()->all());
        $current_password = Auth::guard('dealer')->user()->password;
        $oldpassword = request()->old_password;

        $newpassword = request()->new_password;
        $confirmpassword = request()->confirm_password;
        if($newpassword == $confirmpassword){
            if(Hash::check($old_password,$newpassword)){
                Auth::guard('dealer')->user()->update(['password'=>bcrypt($newpassword)]);
                return redirect()->back()->with('message','Password Changed Successfully');
            }else{
                return redirect()->back()->with('error','Old Password Not Matched, password not updated.');
            }

        }else{
            return redirect()->back()->with('error','Password and Confirm Password Not Matched, password not updated.');
        }
    }
}
