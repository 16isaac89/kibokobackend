<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\CustomerCategory;
use App\Models\Customer;
use App\Models\RepRoute;
use App\Models\RoutePlanList;
use App\Models\Performance;

class CustomersController extends Controller
{
    public function getRoutes(){
        $routes = Route::with('customers')->where('dealer_id',request()->dealer)->get();
       //$routes = RepRoute::with('route')->where('dealer_user_id',request()->user)->get();
        return response()->json(['routes'=>$routes]);
    }
    public function getCategories(){
        $categories = CustomerCategory::all();
        return response()->json(['categories'=>$categories]);
    }
	public function kibokostore(){
		  $id = request()->userid;
        $week = request()->week;
        $day = request()->day;
		$customer = request()->id;
        $routes = Route::with('customers')->where('dealer_id',request()->dealer)->get();
        $route = Route::find(request()->route);
		if($customer){
			$client = Customer::find($customer);
			$client->update([
			'name'=>request()->name,
                'phone'=>request()->phone,
                'category_id'=>request()->category,
                'route_id'=>request()->route,
                'dealer_id'=>request()->dealer,
                'status'=>1,
                'identification'=> uniqid(),
                //'tin'=>request()->tin,
                'efrisstatus'=>request()->registered,
                'address'=>request()->address,
                //'buyertypecode'=>request()->buyertypecode,
                'branch_id'=>1,
				'email'=>request()->email,
                'buyerType'=>1,
				'contact_person'=>request()->contactperson,
				'telno'=>request()->telephoneno,
				'area'=>request()->area,
				'city'=>request()->city,
				'country'=>request()->country,
				'classification'=>request()->classification,
				'cashregisters'=>request()->cashregisters,
				'dailyfootfall'=>request()->dailyfootfall,
				'productrange'=>request()->productrange,
				'custcategory'=>request()->custcategory,
                'latitude'=>request()->lat,
        		'longitude'=>request()->long,
                'route_code'=>$route->code,

			]);

			return response()->json(['message'=>'Customer updated successfully','customers'=>[],'routes'=>$routes]);
		}else{
       $customer =  Customer::create(
            [
                'name'=>request()->name,
                'phone'=>request()->phone,
                'category_id'=>request()->category,
                'route_id'=>request()->route,
                'dealer_id'=>request()->dealer,
                'status'=>1,
                'identification'=> uniqid(),
                //'tin'=>request()->tin,
                'efrisstatus'=>request()->registered,
                'address'=>request()->address,
                //'buyertypecode'=>request()->buyertypecode,
                'branch_id'=>1,
				'email'=>request()->email,
                'buyerType'=>1,
				'contact_person'=>request()->contactperson,
				'telno'=>request()->telephoneno,
				'area'=>request()->area,
				'city'=>request()->city,
				'country'=>request()->country,
				'classification'=>request()->classification,
				'cashregisters'=>request()->cashregisters,
				'dailyfootfall'=>request()->dailyfootfall,
				'productrange'=>request()->productrange,
				'custcategory'=>request()->custcategory,
                'latitude'=>request()->lat,
        		'longitude'=>request()->long,
                'route_code'=>$route->code,

            ]
            );

            RoutePlanList::create([
                'customer_id'=>$customer->identification,
                'name'=>$customer->name,
                'routename'=>$customer->route->name,
                'route_id'=>request()->route,
                'dealer_user_id'=>$id,
                'dealer_id'=>request()->dealer,
                'week'=>1,
                'day'=>1,
            ]);

            $customers="";
       $custs = RoutePlanList::with(['customer','route'])->where(['dealer_user_id'=>$id,'week'=>$week,'day'=>$day])->get();
        if($custs){
            $customers = $custs;
        }else{
            $customers = array();
        }
        Performance::create([
            'user'=>request()->userid,
            'points'=>1,
            'pointtype'=>'createcustomer',
          ]);

            return response()->json(['message'=>'Customer saved','customers'=>$customers,'routes'=>$routes]);
		}
	}
    public function store(){
        $id = request()->id;
        $week = request()->week;
        $day = request()->day;

       $customer =  Customer::create(
            [
                'name'=>request()->name,
                'phone'=>request()->phone,
                'category_id'=>request()->category,
                'route_id'=>request()->route,
                'dealer_id'=>request()->dealer,
                'status'=>1,
                'identification'=> uniqid(),
                'tin'=>request()->tin,
                'efrisstatus'=>request()->registered,
                'address'=>request()->address,
                //'buyertypecode'=>request()->buyertypecode,
                'branch_id'=>request()->branch,
                'buyerType'=>request()->buyertypecode,
            ]
            );

            RoutePlanList::create([
                'customer_id'=>$customer->identification,
                'name'=>$customer->name,
                'routename'=>$customer->route->name,
                'route_id'=>request()->route,
                'dealer_user_id'=>$id,
                'dealer_id'=>request()->dealer,
                'week'=>request()->week,
                'day'=>request()->day,
            ]);

            $customers="";
       $custs = RoutePlanList::with(['customer','route'])->where(['dealer_user_id'=>$id,'week'=>$week,'day'=>$day])->get();
        if($custs){
            $customers = $custs;
        }else{
            $customers = array();
        }
        Performance::create([
            'user'=>request()->userid,
            'points'=>1,
            'pointtype'=>'createcustomer',
          ]);

            return response()->json(['message'=>'Customer saved','customers'=>$customers]);

    }
    public function storesaved(){
        Customer::create(
            [
                'name'=>request()->name,
                'phone'=>request()->phone,
                'category_id'=>request()->category,
                'route_id'=>request()->route,
                'dealer_id'=>request()->dealer,
                'status'=>1,
                'identification'=>request()->id,
                'tin'=>request()->tin,
                'efrisstatus'=>request()->efrisstatus,
                'address'=>request()->address,
                'buyertypecode'=>request()->buyertypecode,
                'branch_id'=>request()->branch
            ]
            );
            Performance::create([
                'user'=>request()->userid,
                'points'=>1,
                'pointtype'=>'createcustomer',
              ]);
    return response()->json(['message'=>1]);
    }
}