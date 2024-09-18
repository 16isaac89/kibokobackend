<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DealerUser;
use Auth;
use App\Models\Van;
use App\Models\Target;
use Carbon\Carbon;
use App\Models\RepRoute;
use App\Models\RoutePlanList;
use App\Models\SkuTarget;
use App\Models\DealerRole;
use App\Models\Branch;

class DealerUserController extends Controller
{
    public function home(){
        if(\Auth::guard('dealer')->check()){
            $dealer = Auth::guard('dealer')->user()->dealer_id;
            $currentdate = Carbon::now()->month();
            $roles = DealerRole::where('dealer_id',$dealer)
            ->orWhere('dealer_id',0)
        ->get();


        $users = DealerUser::with(['van','target'=>function($q)use($currentdate){
            //$q->whereMonth('month', Carbon::now()->month)->get();
            $q->whereMonth('month',$currentdate)->first();
        },
        'sales'=>function($q)use($currentdate){
            $q->whereMonth('created_at', Carbon::now()->month)->sum('total');
        },
        'skutarget'=>function($q)use($currentdate){
            //$q->whereMonth('month', Carbon::now()->month)->get();
            $q->with('items')->whereMonth('month',$currentdate)->first();
        }])->where('dealer_id',$dealer)->get();
         //dd($users);
        $vans = Van::where('dealer_id',$dealer)->get();
        $branches = Branch::where('dealer_id',Auth::guard('dealer')->user()->dealer_id)->get();
       // dd($users);
        return view('dealer.users.index',compact('users','vans','roles','branches'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function save(){
        if(\Auth::guard('dealer')->check()){
        $dealer = Auth::guard('dealer')->user()->dealer_id;
        $user  = DealerUser::create([
        'dealer_id'=>$dealer,
        'type'=>request()->type,
        'username'=>request()->username,
        'phone'=>request()->phone,
        'password'=>bcrypt(request()->password),
        'van_id'=>request()->van,
        'status'=>request()->status,
        'targettype'=>request()->target,
        'branch_id'=>request()->branch_id
        ]);
        $user->dealerroles()->sync(request()->input('roles', []));
        return back();
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function updateUserForm(){
        if(\Auth::guard('dealer')->check()){
        $dealer = Auth::guard('dealer')->user()->dealer_id;
        $user = DealerUser::with('dealerroles','branch')->find(request()->user);
       // dd($user);
        $vans = Van::where('dealer_id',$dealer)->get();
        $roles = DealerRole::where('dealer_id',$dealer)
        ->orWhere('dealer_id',0)
            ->get();
            $branches = Branch::where('dealer_id',Auth::guard('dealer')->user()->dealer_id)->get();
        return view('dealer.users.edit',compact('vans','user','roles','branches'));
        }else{
            return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
        }

    }
    public function updateUser(){
       // dd(request()->all());
        if(\Auth::guard('dealer')->check()){
        $user = DealerUser::find(request()->userid);
        $user->update([
            'type'=> request()->dealerusertype ? request()->dealerusertype : $user->type,
            'username'=>request()->dealerusername ? request()->dealerusername : $user->username,
            'phone'=>request()->dealeruserphone ? request()->dealeruserphone : $user->phone,
            'van_id'=>request()->dealeruservan ? request()->dealeruservan : $user->van_id,
            'status'=>request()->dealeruserstatus ? request()->dealeruserstatus : $user->status,
            'targettype'=>request()->target,
            'branch_id'=>request()->branch_id
        ]);
        $user->dealerroles()->sync(request()->input('roles', []));
        return redirect()->route('dealer.users.index');
        //return back();
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function updatepwd(){
        if(\Auth::guard('dealer')->check()){
        DealerUser::find(request()->userid)->update([
            'password'=>bcrypt('12345'),
        ]);
        return back();
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    public function userdetails(){
        $routeplans = RoutePlanList::where('dealer_user_id',request()->userid)->get();
        $routes = RepRoute::where('dealer_user_id',request()->userid)->get();
        return view('dealer.users.details',compact('routeplans','routes'));
    }

    public function deleteplan(){
        $id = intVal(request()->routeplan);
         RoutePlanList::find($id)->delete();

        return back();
    }
    public function deleteroute(){
        RepRoute::find(request()->reproute)->delete();
        return back();
    }
    public function targethistory(){
        //dd(request()->month);
        $user = DealerUser::find(request()->dealeruser);
        //dd($user);
        $targettype = $user->targettype;
        if($targettype === 'month'){
            //$target = Target::whereMonth('month',date(request()->month))->first();
            $target = Target::where('user_id',request()->dealeruser)->whereDate('fromdate', '>=',request()->fromdate)->whereDate('todate',request()->todate)->first();
            //dd($target);
            return view('dealer.users.targethistory',compact('target','targettype'));
        }else{
        //$target = SkuTarget::with('items')->where('user_id',request()->dealeruser)->whereMonth('month',date(request()->month))->first();
        $target = SkuTarget::with('items')->where('user_id',request()->dealeruser)->whereDate('fromdate', '>=',request()->fromdate)->whereDate('todate',request()->todate)->first();

        return view('dealer.users.targethistory',compact('target','targettype'));
        }
    }

}
