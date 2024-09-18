<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DealerSubscription;
use App\Models\Subscription;
use App\Models\Setting;
use DB;
use App\Models\Dealer;

class DealerSubscriptionController extends Controller
{
    public function store(Request $request){
        //dd($request->all());
        DB::beginTransaction();
        try {
            $subtype = $request->subtype;
        $sub = Subscription::find(intval($request->subscription_id));
        //return response()->json(['price'=>$sub,'s'=>$request->sub,'x'=>$request->input()]);
        $price = 0;
        if($sub->type === 'month'){
            $price = Setting::where('setting','per_user_value')->get()->first()->value;
        }else if($sub->type === 'year'){
            $price = Setting::where('setting','per_year_sub')->get()->first()->value;
        }
        $dealer = Dealer::find($request->dealer_id);

        $dealer->subscription_id = $request->subscription_id;
        $dealer->save();
        DealerSubscription::create([
            'subscription_id'=>$request->subscription_id,
            'dealer_id'=>$request->dealer_id,
            'from_date'=>$request->from_date,
            'to_date'=>$request->to_date,
            'paid_on'=>$request->paidon,
            'transaction_id'=>$request->transaction,
            'status'=>'completed',
            'discount'=>$request->discount,
            'quantity'=>$request->totalmonths,
            'ammount'=>intval($price)*intval($request->totalmonths),
            'ptmethod'=>$request->ptmethod,
        ]);
        DB::commit();
        return redirect()->back()->with('success', 'Subscription added');

        } catch (\Exception $ex) {

            DB::rollback();
            dd($ex);
            return redirect()->back()->with('error', $ex->getMessage());
         // return response()->json(['error' => $ex->getMessage()], 500);
        }



    }
}
