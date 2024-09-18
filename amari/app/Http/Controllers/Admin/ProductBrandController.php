<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductBrand;
use App\Models\Product;

class ProductBrandController extends Controller
{
   public function index(){
    $brands = ProductBrand::all();
    return view('admin.productbrands.index',compact('brands'));
   }
   public function store(){
    $brands = ProductBrand::create([
        'name'=>request()->name,
    ]);
    return back();
   }
   public function editBrand(){
    ProductBrand::find(request()->brandid)->update([
        'name'=>request()->brandname,
    ]);
    return back();
   }
   public function brandProducts(){
    $products = Product::where('brand_id',request()->brand)->get();
    return response()->json(['products'=>$products]);
   }
   public function delete(){
    $brand = ProductBrand::find(request()->brand);
    $products = Product::where('brand_id',request()->brand)->delete();
    //Product::delete(collect($products));
    $brand->delete();
    return redirect()->back()->with('success', 'Brand with related products have been deleted.');
   }
}
