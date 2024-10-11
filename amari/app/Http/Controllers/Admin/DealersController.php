<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Http\Controllers\Helper\MediaClass;
use App\Models\DealerUser;
use App\Models\Target;
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\DealerRole;
use App\Models\Subscription;
use App\Models\Setting;
use App\Http\Controllers\Traits\CsvImportTrait;

class DealersController extends Controller
{
    use CsvImportTrait;
    public function index(){
        $dealers = Dealer::all();
        return view('admin.dealers.index',compact('dealers'));
    }
    public function store(){
        $media = new MediaClass();
        $path = 'uploads/dealers/keys/';
        if(request()->privatekey){
            $file = request()->privatekey;
            $filepath = $media->uploads($file,$path);
        }

         $privatekeypath = isset($request->privatekey) && !empty($request->privatekey) ? \URL::to('/')."/amari/storage/app/public/".$filepath['filePath'] : "";

        $dealer = Dealer::create([
            'tradename'=>request()->name,
            'tin'=>request()->tin,
            'address'=>request()->address,
            'phonenumber'=>request()->phonenumber,
            'status'=>request()->status,
            'efris'=>request()->efris,
            'deviceno'=>request()->deviceno,
            'privatekey'=> $privatekeypath,
            'keypwd'=>request()->keypwd,
            'email'=>request()->email,
            'code'=>request()->code,
        ]);
Branch::create([
    'name'=>request()->branch,
    'address'=>request()->address,
    'phone'=>request()->phonenumber,
    'dealer_id'=>$dealer->id,
]);
        return back();
    }
    public function editDealer(){
        Dealer::find(request()->dealerid)->update([
            'tradename'=>request()->dealername,
            'tin'=>request()->dealertin,
            'address'=>request()->dealeraddress,
            'phonenumber'=>request()->dealerphonenumber,
            'status'=>request()->dealerstatus,
            'efris'=>request()->dealerefris,
            'type_of_business'=>request()->business_type,
        ]);
        return back();
    }

    public function savedealeradmin(){
        $roles = DealerRole::where('title','admin')->pluck('id');
        $branch = Branch::where('dealer_id',request()->iddealer)->first();
        $user = DealerUser::create([
            'dealer_id'=>request()->iddealer,
            'type'=>"admin",
            'username'=>request()->username,
            'phone'=>request()->phone,
            'password'=>bcrypt(request()->password),
            'status'=>request()->userstatus,
            ]);
            $user->dealerroles()->sync($roles);
            return back();
    }

    public function dealerTarget(){
        $data = \DB::table('targets')->where('dealer_id',request()->targetdealer)->whereRaw('extract(month from month) = ?', [Carbon::now()->format('m')])->get();
        if(count($data) > 0){
            return \Redirect::back()->withErrors(['msg' => 'You have already set a target for this dealer this month']);
        }else{
            Target::create([
                'month'=>request()->date,
                'money'=>request()->money,
                'dealer_id'=>request()->targetdealer,
                'type'=>'dealer',
            ]);
            return back();
        }

    }

    public function show(Dealer $dealer){
        // $subscriptions = $dealer->dealersubs;
        // $lates =  = $dealer->dealersubslat;
        $dealer->load('dealerclients');
//d($dealer);

        return view('admin.dealers.show',compact('dealer'));

    }
    public function addsub(Dealer $dealer){
        // $subscriptions = $dealer->dealersubs;
        // $lates =  = $dealer->dealersubslat;
        $subscriptions = Subscription::all();

        return view('admin.dealers.addsub',compact('dealer','subscriptions'));

    }
    public function subprice(Request $request){
        $sub = Subscription::find(intval($request->sub));
        //return response()->json(['price'=>$sub,'s'=>$request->sub,'x'=>$request->input()]);
        $price = 0;
        if($sub->type === 'month'){
            $price = Setting::where('setting','per_user_value')->get()->first()->value;
            return response()->json(['price'=>$price]);
        }else if($sub->type === 'year'){
            $price = Setting::where('setting','per_year_sub')->get()->first()->value;
           return response()->json(['price'=>$price]);
        }

    }
}
