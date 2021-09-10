<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::whereNotNull('login_token')->where('login_token', $request->token)->first();

        if ($user) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized User'
        ], 401);
    }
}
