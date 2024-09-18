<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(){
        $settings = Setting::all();
        return view('admin.settings.index',compact('settings'));
    }
    public function create(Request $request)
    {
        return view('admin.settings.create');
    }


    public function store(Request $request)
    {
        Setting::create([
            'setting'=>$request->setting,
            'value'=>$request->value,
        ]);
        return redirect()->back()->with('message','Setting saved Successfully');

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
