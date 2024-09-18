<?php

namespace App\Http\Controllers\dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductUnit;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(\Auth::guard('dealer')->check()){
          $dealer = \Auth::guard('dealer')->user()->dealer_id;
          $units = ProductUnit::where('dealer_id',0)->orWhere('dealer_id',$dealer)->get();
          return view('dealer.units.index',compact('units'));
        }else{
            return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(\Auth::guard('dealer')->check()){
            $dealer = \Auth::guard('dealer')->user()->dealer_id;
            $units = ProductUnit::where('dealer_id',0)->orWhere('dealer_id',$dealer)->get();
            return view('dealer.units.create',compact('units'));
          }else{
              return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // dd($request->all());
        if(\Auth::guard('dealer')->check()){
            $dealer = \Auth::guard('dealer')->user()->dealer_id;
            ProductUnit::create([
                'name'=>$request->name,
                'shortname'=>$request->short_name,
                'allow_decimal'=>$request->allow_decimal,
                'has_base'=>$request->asmultiple === 'on' ? 1 : 0,
                'dealer_id'=>$dealer,
                'base_unit'=>$request->base_unit,
                'multiplier'=>$request->multiplier,
            ]);
            return redirect()->back()->with('message', 'Unit saved successfully.');
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
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
    public function edit(ProductUnit $productunit)
    {
// dd($productunit);
        if(\Auth::guard('dealer')->check()){
     $unit = $productunit;
     $dealer = \Auth::guard('dealer')->user()->dealer_id;
            $units = ProductUnit::where('dealer_id',0)->orWhere('dealer_id',$dealer)->get();
        return view('dealer.units.edit',compact('unit','units'));
    }else{
        return redirect()->route("dealer.login.view")->with('status','Opps! You have entered invalid credentials');
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = ProductUnit::find($id);
        $unit->update([
            'name'=>$request->name,
            'shortname'=>$request->short_name,
            'allow_decimal'=>$request->allow_decimal,
        ]);
        return redirect()->back()->with('message', 'Unit updated successfully.');	
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
        $unit = ProductUnit::find($id);
        $unit->delete();
        return redirect()->back()->with('message', 'Unit deleted successfully.');
    }
}
