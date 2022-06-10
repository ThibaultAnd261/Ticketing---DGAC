<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // si l'utilisateur souhaite accéder à une page où il est nécessaire de se connecter (middleware('auth'), alors on redirige vers la route('acc') qui correspond à la page d'accueil
            return route('acc');
        }
    }
}
