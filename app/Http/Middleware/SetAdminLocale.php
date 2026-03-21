<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetAdminLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('admin_locale')) {
            app()->setLocale($request->session()->get('admin_locale'));
        } else {
            app()->setLocale(config('app.locale'));
        }
        return $next($request);
    }
}