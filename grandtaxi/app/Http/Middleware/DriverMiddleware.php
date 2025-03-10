<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverMiddleware
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
        // Check wach l'user connecté w huwa driver
        if (!Auth::check() || Auth::user()->role !== 'driver') {
            // Redirect l home page wla login page m3a message d'erreur
            return redirect()->route('home')->with('error', 'Accès non autorisé. Page réservée aux chauffeurs.');
        }

        return $next($request);
    }
}
