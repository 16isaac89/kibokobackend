<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionsController extends Controller
{
    public function index(){
        $subscriptions = Subscription::all();
        return view('admin.subscription.index',compact('subscriptions'));
    }
    public function create(Request $request)
    {
        return view('admin.subscription.create');
    }


    public function store(Request $request)
    {
        Subscription::create([
            'name'=>$request->name,
            'type'=>$request->type,
            'description'=>$request->description,
            'grace_period'=>$request->grace_period,
            'days'=>$request->days
        ]);
        return redirect()->back()->with('message','Subscription saved Successfully');

    }

    public function edit(Setting $setting)
    {

    }
    public function update(Setting $setting)
    {

    }
    public function destroy(Setting $setting)
    {

    }
}
