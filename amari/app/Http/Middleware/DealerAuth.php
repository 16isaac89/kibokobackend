<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DealerRole;
use Gate;
class DealerAuth
{
    public function handle($request, Closure $next)
    {
        $user = \Auth::guard('dealer')->user();
        if ($user) {
            $user->load('dealerroles');
            $dealerid = \Auth::guard('dealer')->user()->dealer_id;
            $roles            = DealerRole::with('dealerpermissions')
								->where('dealer_id',$dealerid)
								->orWhere('dealer_id',0)
								->get();
           // dd($roles);
            $permissionsArray = [];
            foreach ($roles as $role) {
                foreach ($role->dealerpermissions as $permissions) {

                    $permissionsArray[$permissions->title][] = $role->id;
                }
            }
        //dd($user->dealerroles);
            foreach ($permissionsArray as $title => $roles) {
                Gate::define($title, function () use ($roles,$user) {
                    return count(array_intersect($user->dealerroles->pluck('id')->toArray(), $roles)) > 0;
                });
            }
          //dd($permissionsArray);

        }

        return $next($request);
    }

    }

