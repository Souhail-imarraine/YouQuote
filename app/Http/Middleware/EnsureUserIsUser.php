<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()) {
            return response()->json(['message' => 'Non authentifié.'], 401);
        }

        if (Auth::user()->role === 'user') {
            // dd(Auth::user()->role);
            return $next($request);
        }

        return response()->json(['message' => 'Accès refusé. Utilisateur uniquement.'], 403);
    }
}
