<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAboutMe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->is_admin) {
            return $next($request);
        }

        $hasCreatedAboutMe = $user->aboutmes()->exists();

        if ($hasCreatedAboutMe) {
            return redirect('/aboutmes')->with('error', 'You have already created an About Me page.');
        }
        return $next($request);
    }
}
