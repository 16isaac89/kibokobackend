<?php

namespace App\Http\Controllers\Api\V1\Sales\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Validation\Rule;
use Validator;
use Arr;
use App\Models\DealerUser;
use App\Models\SalesPersonLogin;
use Carbon\Carbon;

class LoginController extends Controller
{
    public $successStatus = 200;
    public function Login(Request $request){
        $customer = DealerUser::where(['phone'=>$request->username,'status'=>1])->first();
//return response()->json(['a'=>request()->all()]);
    if($customer){
        if (!Hash::check($request->password, $customer->password)) {
            return response()->json(['message'=>'Wrong username or password','status'=>'0'], 422);
        }
        $success['token'] =  $customer->createToken('exdefds123')->plainTextToken;
        $customer->authtoken = $success['token'];
        $customer->save();
        $customeracc = DealerUser::with('dealer')->find($customer->id);
        SalesPersonLogin::create([
            'user_id'=>$customeracc->id,
            'login_time'=>Carbon::now()->format('H:i:s'),   
        ]);
        return response()->json(['customer'=>$customeracc,'Success'=>$success,'status'=>'1'], $this->successStatus);
    }else{
        return response()->json(['message'=>'A user with these credentials does not exist or account not active.'], 422);
    }
}

public function logout(){
	$salesperson = SalesPersonLogin::where('user_id',request()->id)->whereDate('created_at',Carbon::today())->get()->first();
	if($salesperson){
		$salesperson->logout_time = Carbon::now()->format('H:i:s');
		$salesperson->save();
		return response()->json(['message'=>'Log out successful.'], 200);
	}else{
	SalesPersonLogin::create([
		'logout_time' => Carbon::now()->format('H:i:s'),
		'login_time' => Carbon::now()->format('H:i:s'),
		'user_id'=>request()->id,
		]);
		return response()->json(['message'=>'You did not log out previously.'], 200);
	}
    
   
}



}
