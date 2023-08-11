<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate;

class RoleBasedLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        if (auth()->check() && auth()->user()->admin == 5) {
            $currentDay = now()->dayOfWeek;

            if ($currentDay === 0 || $currentDay === 6) { // Cek jika hari adalah Minggu (0) atau Sabtu (6).
                return redirect()->route('home')->withErrors(['login' => 'Anda tidak dapat masuk pada hari Sabtu atau Minggu.']);
                // return die('Anda tidak dapat masuk pada hari Sabtu atau Minggu.');
            }
        }

        return $next($request);
    }
}
