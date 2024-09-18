<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;

class ProductsCategoryController extends Controller
{
    public function index(){
        $categories = ProductCategory::all();
        return view('admin.productcategories.index',compact('categories'));
    }
    public function store(){
        ProductCategory::create([
            'name'=>request()->name
        ]);
        return back();
    }
    public function edit(){
        //dd(request()->all());
        $category = ProductCategory::find(request()->catid);
        $category->update([
            'name'=>request()->catname,
        ]);
        return back();
    }
    public function delete(){
        $category = ProductCategory::find(request()->category);
        $products = Product::where('product_category_id',request()->category)->delete('id');
        //Product::destroy(collect($products));
        $category->delete();
        return redirect()->back()->with('success', 'Category with related products have been deleted.');
    }
}
