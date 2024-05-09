<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    public function handle(Request $request, $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Rute login Anda
        }

        return $next($request);
    }
}