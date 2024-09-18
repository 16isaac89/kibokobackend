<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    public function index(){
        $expenses = Expense::with('category')->get();
return view('admin.expenses.index',compact('expenses'));
    }
    public function create()
    {
        abort_if(Gate::denies('expense_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = ExpenseCategory::all();
        return view('admin.expenses.create', compact('categories'));
    }
    public function store(Request $request)
    {
        Expense::create($request->all());
        return redirect()->route('admin.expenses.index');
    }
    public function edit(Expense $expense)
    {
     
        abort_if(Gate::denies('expense_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = ExpenseCategory::all();
        return view('admin.expenses.edit', compact('expense','categories'));
    }

    public function update(Expense $expense)
    {

        $expense->update(request()->all());
        
        return redirect()->route('admin.expenses.index');
    }
    public function destroy()
    {
        
        abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $expense = Expense::find(request()->expense);
        $expense->delete();

        return back();
    }

}
