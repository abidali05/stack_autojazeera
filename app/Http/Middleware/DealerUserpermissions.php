<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DealerUserpermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if(Auth::user()->role == 2){
            
            $userPermissions = UserPermission::where('user_id', Auth::user()->id)->pluck('permissions')->toArray();
            if(in_array($permission, $userPermissions)){
                return $next($request);
            }
            else{
                 return redirect()->route('unauthorized');
            }
        }

        return $next($request);
    }
}
