<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class CheckPermissionUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $listPermissions = Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray();
        $permissionAction = Route::getCurrentRoute()->getName();
        
        if (!in_array(str_replace('.', '_', $permissionAction), $listPermissions)) {
            return back()->with('error', 'Bạn không có quyền!');
        }

        return $next($request);
    }
}
