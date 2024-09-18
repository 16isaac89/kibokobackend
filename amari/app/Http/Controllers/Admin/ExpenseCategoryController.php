<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ExpenseCategoryController extends Controller
{
    public function index(){
        $categories = ExpenseCategory::all();
return view('admin.expensecategory.index',compact('categories'));
    }
    public function create()
    {
        abort_if(Gate::denies('expense_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.expensecategory.create');
    }
    public function store(Request $request)
    {
        ExpenseCategory::create($request->all());
        return redirect()->route('admin.expensecategories.index');
    }
    public function destroy()
    {
        
        abort_if(Gate::denies('expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category = ExpenseCategory::find(request()->category);
        $category->delete();

        return back();
    }
    public function edit(ExpenseCategory $expensecategory)
    {
     
        abort_if(Gate::denies('expense_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.expensecategory.edit', compact('expensecategory'));
    }

    public function update(ExpenseCategory $expensecategory)
    {

        $expensecategory->update(request()->all());
        
        return redirect()->route('admin.expensecategories.index');
    }

}
