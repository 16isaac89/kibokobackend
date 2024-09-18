<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\DealerUser;
use App\Models\Van;
use App\Models\Route;
use Carbon\Carbon;

class SearchReportsController extends Controller
{
   public function rep(){
    $sales = DealerUser::with(['plans','target'=>function($q){
        $q->whereMonth('month', request()->month)->whereYear('created_at', request()->year);
            },'sales'=>function($q){
        $q->with('items','customer')->whereMonth('created_at',request()->month)->whereYear('created_at', request()->year);
        }])->get();
return view('admin.reports.rep',compact('sales'));
   }

   public function van(){
    $sales = Van::with(['target'=>function($q){
        $q->whereMonth('month',Carbon::now()->month)->get();
    },
    'sales'=>function($q){
        $q->with('items','customer')->whereMonth('created_at',request()->month)->whereYear('created_at', request()->year);
        },])->get();
    return view('admin.reports.van',compact('sales'));
}


}
