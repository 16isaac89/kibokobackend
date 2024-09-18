<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::where('dealer_id', \Auth::guard('dealer')->user()->dealer->id)->get();
        return view('dealer.taxes.index', compact('taxes'));
    }
    public function create()
    {
        return view('dealer.taxes.create');
    }
    public function store()
    {
        Tax::create([
            'name' => request()->name,
            'value' => request()->value,
            'dealer_id' => \Auth::guard('dealer')->user()->dealer->id,
        ]);
        return redirect()->route('dealertaxes.index');
    }
}
