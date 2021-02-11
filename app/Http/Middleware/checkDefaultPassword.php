<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkDefaultPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->password_changed_at == null)
        {
            return redirect('dashboard');
        }
        return $next($request);
    }
}
