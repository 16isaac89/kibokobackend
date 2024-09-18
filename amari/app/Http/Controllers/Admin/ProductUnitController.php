<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductUnit;

class ProductUnitController extends Controller
{
    public function index(){
        $units = ProductUnit::all();
        return view('admin.units.index',compact('units'));
    }

public function viewadd(){
    return view('admin.units.add');
}
    public function store(){
        ProductUnit::create([
        'name'=>request()->name,
        'shortname'=>request()->shortname,
        ]);
        $units = ProductUnit::all();
        return view('admin.units.index',compact('units'));
    }

    public function update(){
        ProductUnit::find(request()->unit)->update([
            'name'=>request()->name,
            'shortname'=>request()->shortname,
        ]);
        $units = ProductUnit::all();
        return view('admin.units.index',compact('units'));
    }
    public function edit(){
        $unit = ProductUnit::find(request()->unit);
        return view('admin.units.edit',compact('unit'));
    }
}
