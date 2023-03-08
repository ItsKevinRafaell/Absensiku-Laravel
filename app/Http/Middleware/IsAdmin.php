<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
        if (auth()->user()->role_id == 1) {
            return $next($request);
        } elseif (auth()->user()->role_id == 2) {
            return redirect('home')->with('error', "Anda Tidak Dapat Mengakses Halaman Ini");
        } elseif (auth()->user()->role_id == 3) {
            return $next($request);
        }
        return redirect('home')->with('error', "Anda Tidak Dapat Mengakses Halaman Ini");
    }
}
