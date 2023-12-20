<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Redirect;
class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if(Auth::check())
        {
            if($user->role == 1)
            {
                $response = $next($request);
                return $response;
            }
            else
            {
                return back();
            }
        }
        return Redirect::route('user.logout')->with('loginFirst', 'You must logged in first!');
    }
}
