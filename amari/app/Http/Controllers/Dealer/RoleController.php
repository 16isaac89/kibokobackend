<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DealerRole;
use App\Models\DealerPermission;
use App\Http\Requests\StoreDealerRoleRequest;
use App\Http\Requests\UpdateDealerRoleRequest;

class RoleController extends Controller
{
    public function index(){
        if(\Auth::guard('dealer')->check()){
        $dealerid = \Auth::guard('dealer')->user()->dealer_id;
        $roles = DealerRole::where('dealer_id',$dealerid)
                            ->with(['dealerpermissions'])->get();

        return view('dealer.roles.index', compact('roles'));
        }
        return redirect()->route("dealer.login.page")->withSuccess('Opps! You do not have access');
    }
    public function create(){
        if(\Auth::guard('dealer')->check()){
            $dealerid = \Auth::guard('dealer')->user()->dealer_id;
            $permissions = DealerPermission::all();
            return view('dealer.roles.create', compact('permissions'));
            }
            return redirect()->route("dealer.login.page")->withSuccess('Opps! You do not have access');
    }


    public function store(StoreDealerRoleRequest $request)
    {
        $role = DealerRole::create($request->all());
        $role->dealerpermissions()->sync($request->input('permissions', []));

        return redirect()->route('dealerroles.index');
    }
    public function edit(DealerRole $dealerrole)
    {
        $permissions = DealerPermission::all();

        $dealerrole->load('dealerpermissions');

        return view('dealer.roles.edit', compact('permissions', 'dealerrole'));
    }
    public function update(UpdateDealerRoleRequest $request, DealerRole $dealerrole)
    {
        $dealerrole->update($request->all());
        $dealerrole->dealerpermissions()->sync($request->input('permissions', []));
        return redirect()->route('dealerroles.index');
    }

}
