<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminOrUserAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $employee = auth()->user()->employee;

        if ($employee && ($employee->role === 'Admin' || auth()->user()->isAdmin())) {
            return $next($request);
        }

        return redirect()->route('index')->with('error', 'Unauthorized.');
    }
}
