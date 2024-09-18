<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{

public function index(){
    if(Auth::guard('customers')->check()){
        $userId = Auth::guard('customers')->user()->id;
        $orders = Booking::where('customer_id',$userId)->paginate(4);

        $count = count($orders);
       // dd($count);
        return view('customer.index',['orders'=>$orders, 'myorders'=>$count]);
     }
     return redirect()->route("customer.login.view")->withSuccess('Opps! You do not have access');

}

public function Receipt(Request $request){
    $id = intval($request->route('id'));
    $booking = Booking::find($id)->first();
    //dd($booking->phone);
    return view('customer.receipt')->with('booking',$booking);
}
public function profile(){
    if(Auth::guard('customers')->check()){
        $userId = Auth::guard('customers')->user()->id;
        $orders = Booking::where('customer_id',$userId)->get();
        $completed = count(Booking::where('customer_id',$userId)->where('status','completed')->get());
        $cancelled = count(Booking::where('customer_id',$userId)->where('status','cancelled')->get());
        $upcoming = count(Booking::where('customer_id',$userId)->where('status','received')->get());

        $count = count($orders);
        return view('customer.profile',['count'=>$count,'completed'=>$completed,'cancelled'=>$cancelled,'upcoming'=>$upcoming]);
    }
    return redirect()->route("customer.login.view")->withSuccess('Opps! You do not have access');
}


}
