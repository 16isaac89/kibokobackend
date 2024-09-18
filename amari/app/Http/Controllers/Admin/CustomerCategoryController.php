<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerCategory;

class CustomerCategoryController extends Controller
{
    public function index(){
        $categories = CustomerCategory::all();
        return view('admin.customercategory.index',compact('categories'));
    }
    public function edit(){
        
        $x = CustomerCategory::find(request()->categoryid);
        $x->name = request()->categoryname;
        $x->save();
      
        $categories = CustomerCategory::all();
        return view('admin.customercategory.index',compact('categories'));
    }
    public function store(){
        CustomerCategory::create([
            'name'=>request()->name,
        ]);
        $categories = CustomerCategory::all();
        return view('admin.customercategory.index',compact('categories'));
    }
}
