<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Dealer;
use App\Http\Controllers\Traits\CsvImportTrait;

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

        $dealer = Dealer::find($request->dealer);
        $route->update([
            'name'=>$request->name,
            'dealer_id'=>$request->dealer,
            'dealer_code'=>$dealer->code,
            'code'=>$request->code
        ]);
        return redirect()->route('admin.routes.index')
            ->with('message','Route updated successfully');
    }
}
