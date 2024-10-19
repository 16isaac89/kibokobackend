<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tax;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taxes = Tax::all();
        return view('admin.taxes.index',compact('taxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.taxes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       Tax::create([
           'name'=>$request->name,
           'value'=>$request->value,
       ]);
       return redirect()->back()->with('message','Tax has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tax $tax)
    {
        return view('admin.taxes.edit',compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tax = Tax::find($request->id);
        $tax->update([
            'name'=>$request->name,
            'value'=>$request->value,
        ]);
        return redirect()->back()->with('message','Tax has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
