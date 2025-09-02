<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Route;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
    use CsvImportTrait;
    public function index(){
        $routes = Route::with('dealer')->get();
        return view('admin.routes.index',compact('routes'));
    }
    public function create(){
        $dealers = Dealer::all();
        return view('admin.routes.create',compact('dealers'));
    }
    public function store(Request $request){
//dd($request->all());
    $dealer = Dealer::find($request->dealer);
        Route::create([
            'name'=>$request->name,
            'dealer_id'=>$request->dealer,
            'dealer_code'=>$dealer->code,
            'code'=>$request->code
        ]);
        return redirect()->route('admin.routes.index')
            ->with('message','Route created successfully.');
    }
    public function edit(Route $route){
        $dealers = Dealer::all();
        return view('admin.routes.edit',compact('route','dealers'));
    }
    public function update(Request $request, Route $route){
        // dd($request->all(),$route);
        $dealer = Dealer::find($request->dealer);
        $customers = Customer::where('route_code',$route->code)->get();

       // dd($customers);
        $route->update([
            'name'=>$request->name,
            'dealer_id'=>$request->dealer,
            'dealer_code'=>$dealer->code,
        ]);
        foreach($customers as $customer){
            $customer->update([
                'dealer_code'=>$dealer->code,
            ]);

        }
        return redirect()->route('admin.routes.index')
            ->with('message','Route updated successfully');
    }
}
