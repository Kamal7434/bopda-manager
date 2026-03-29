<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'utilisateur est connecté et est admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Sinon, on peut le rediriger ou renvoyer 403
        abort(403, 'Accès refusé : administrateur uniquement.');
    }
}