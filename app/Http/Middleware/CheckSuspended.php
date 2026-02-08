<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSuspended
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_suspended) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('error', 'Votre compte a été suspendu. Contactez support@linkcard.ca pour plus d\'informations.');
        }

        return $next($request);
    }
}
