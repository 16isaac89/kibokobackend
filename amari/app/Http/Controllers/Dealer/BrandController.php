<?php

namespace App\Http\Controllers\dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductBrand;
use App\Models\Product;

class BrandController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $brands = ProductBrand::where('dealer_id',\Auth::guard('dealer')->user()->dealer_id)->get();
        return view('dealer.brand.index',compact('brands'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
       }

       public function edit(ProductBrand $dealerbrand){
        if(\Auth::guard('dealer')->check()){
        return view('dealer.brand.edit',compact('dealerbrand'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
       }

       public function create(){
        if(\Auth::guard('dealer')->check()){
        return view('dealer.brand.create');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
       }
       public function store(){
        if(\Auth::guard('dealer')->check()){
        $brands = ProductBrand::create([
            'name'=>request()->name,
            'dealer_id'=>\Auth::guard('dealer')->user()->dealer_id
        ]);
        return redirect()->route('dealerbrands.index');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
       }
       public function update(ProductBrand $dealerbrand){
       // dd(request()->all());
       if(\Auth::guard('dealer')->check()){
     $dealerbrand->update([
            'name'=>request()->name,
        ]);
        return back();
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
       }
       public function brandProducts(){
        $products = Product::where('brand_id',request()->brand)->get();
        return response()->json(['products'=>$products]);
       }
       public function delete(){
        if(\Auth::guard('dealer')->check()){
        $brand = ProductBrand::find(request()->brand);
        $products = Product::where('brand_id',request()->brand)->delete();
        //Product::delete(collect($products));
        $brand->delete();
        return redirect()->back()->with('success', 'Brand with related products have been deleted.');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
       }

}
