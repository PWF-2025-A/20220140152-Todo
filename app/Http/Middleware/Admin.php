<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $user = Auth::guard('api')->user();
        if (!$user || !$user->is_admin) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access',
        ], Response::HTTP_UNAUTHORIZED);
    }

    // Jika admin, izinkan lanjut
    return $next($request);
    }
}
