<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationsController extends Controller
{
    public function index(){
        $locations = Location::all();
        return view('admin.locations.index',compact('locations'));
    }
    public function edit(){
        
        $x = Location::find(request()->locationid);
        $x->name = request()->locationname;
        $x->save();
      
        $locations = Location::all();
        return view('admin.locations.index',compact('locations'));
    }
    public function store(){
        Location::create([
            'name'=>request()->name,
        ]);
        $locations = Location::all();
        return view('admin.locations.index',compact('locations'));
    }
}
