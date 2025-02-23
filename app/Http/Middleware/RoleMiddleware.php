<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//    public function handle(Request $request, Closure $next): Response
//    {
//        return $next($request);
//    }

    public function handle(Request $request, Closure $next, $role)
    {

        if (!Auth::check()) {
            return redirect('login');
        }


        //dd('Middleware exécuté');

/*        $user = Auth::user();
        if ($user->role->name == $role) {
            return $next($request);
        }

        return redirect('home')->with('error', 'Vous n\'avez pas accès à cette section.');*/

 /*       if (!Auth::check() || !Auth::user()->hasRole($role)) {
            dd(Auth::user(), $role);
            abort(403, "Vous n'avez pas la permission d'accéder à cette page.");
        }

        return $next($request);*/
        $user = Auth::user();
        //dd(Auth::user());
        //dd($user->role);
        //dd($user->role);

/*        dd([
            'role_attendu' => $role,
            'role_utilisateur' => $user->role->name
        ]);*/

        // Vérifier si l'utilisateur a bien un rôle et si le rôle correspond
        if (!$user || !$user->role || $user->role->name != $role) {
            abort(403, 'Accès interdit');
        }



/*        if (!$user) {
            // Si l'utilisateur n'est pas authentifié, on retourne un accès interdit
            return abort(403, 'utilisateur interdit');
        }

        //dd($user, $user->role, $user->role->name);

        // Assure-toi que l'utilisateur a un rôle spécifique
        if ($user->role && $user->role->name != $role) {
            return abort(403, 'role interdit');
        }*/

        // Si le rôle ne correspond pas, refuser l'accès avec un code 403
        return $next($request);

    }
}
