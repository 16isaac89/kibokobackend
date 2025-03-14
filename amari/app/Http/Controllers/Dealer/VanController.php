<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\RepRoute;
use App\Models\Van;
use Auth;
use Illuminate\Http\Request;

class VanController extends Controller
{
   public function index(){
    if(\Auth::guard('dealer')->check()){
    $dealer = Auth::guard('dealer')->user()->dealer_id;
    $branch = Auth::guard('dealer')->user()->branch_id;
    $vans = Van::where('dealer_id',\Auth::guard('dealer')->user()->dealer_id)
                 //->where('branch_id',$branch)
                ->get();
    $branches = Branch::where('branch_id',$branch)->get();
    return view('dealer.van.index',compact('vans','branches'));
}else{
    return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
}
   }
   public function store(){
    //dd(request()->all());
    $dealer = Auth::guard('dealer')->user()->dealer_id;
    Van::create([
        'name'=>request()->vanname,
        'reg_id'=>request()->reg_id,
        'dealer_id'=>$dealer,
        'branch_id'=>request()->branch
    ]);
    return back();
   }

   public function updateVan(){

    Van::find(request()->vanid)->update([
        'name'=>request()->vanename,
        'reg_id'=>request()->vanreg
    ]);
    return back();
}
public function assignedplans(Request $request){
    //dd($request->all());
$reproutes = RepRoute::with('list','van','dealeruser')->where('van_id',request()->van)->get();
return view('dealer.van.assignedplans',compact('reproutes'));

}
}
