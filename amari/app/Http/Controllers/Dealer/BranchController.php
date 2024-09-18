<?php

namespace App\Http\Controllers\dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $branches = Branch::where('dealer_id',\Auth::guard('dealer')->user()->dealer_id)->get();
        return view('dealer.branches.index',compact('branches'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function create(){
        if(\Auth::guard('dealer')->check()){
        return view('dealer.branches.create');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function store(){
        if(\Auth::guard('dealer')->check()){
        Branch::create([
            'dealer_id'=>\Auth::guard('dealer')->user()->dealer_id,
            'name'=>request()->name,
            'address'=>request()->address,
            'phone'=>request()->phone,
        ]);
        return redirect()->route('dealerbranches.index');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function edit(Branch $dealerbranch){
        if(\Auth::guard('dealer')->check()){
            return view('dealer.branches.edit',compact('dealerbranch'));
        }else{
            return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
        }
    }
    public function update(Branch $dealerbranch){

        if(\Auth::guard('dealer')->check()){
            $dealerbranch->update([
                'name'=>request()->name,
                'address'=>request()->address,
                'phone'=>request()->phone,
            ]);
            return back();
        }else{
            return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
        }
    }
}
