<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAutentikasiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user && $user->must_reset_password) {
                $allow = $request->is('pages/dashboard')
                    || $request->is('pages/dashboard/*')
                    || $request->is('pages/password/force-reset')
                    || $request->is('pages/logout');

                if (!$allow) {
                    return redirect()
                        ->to('/pages/dashboard')
                        ->with('error', 'Silakan ubah password terlebih dahulu untuk melanjutkan.');
                }
            }

            return $next($request);
        }

        return redirect()->to("/login")->with("error", "Login Terlebih Dahulu");
    }
}
