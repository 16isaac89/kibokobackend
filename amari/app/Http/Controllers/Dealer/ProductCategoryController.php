<?php

namespace App\Http\Controllers\dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $categories = ProductCategory::where('dealer_id',\Auth::guard('dealer')->user()->dealer_id)->get();
        return view('dealer.categories.index',compact('categories'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function create(){
        if(\Auth::guard('dealer')->check()){
        return view('dealer.categories.create');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function store(){
        if(\Auth::guard('dealer')->check()){
        ProductCategory::create([
            'name'=>request()->name,
            'dealer_id'=>\Auth::guard('dealer')->user()->dealer_id
        ]);
        return back();
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function edit(ProductCategory $dealercategory){
        if(\Auth::guard('dealer')->check()){
         return view('dealer.categories.edit',compact('dealercategory'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function update(ProductCategory $dealercategory){
        if(\Auth::guard('dealer')->check()){
            $dealercategory->update([
            'name'=>request()->name,
        ]);
        return back();
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
    public function delete(){
        if(\Auth::guard('dealer')->check()){
        $category = ProductCategory::find(request()->category);
        $products = Product::where('product_category_id',request()->category)->delete('id');
        //Product::destroy(collect($products));
        $category->delete();
        return redirect()->back()->with('success', 'Category with related products have been deleted.');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }
}
