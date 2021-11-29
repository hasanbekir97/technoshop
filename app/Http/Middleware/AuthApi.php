<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApi
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
        $api_key = $request->api_key;

        $user = User::where('api_token', $api_key)
                    ->get('api_token');

        if (isset($user[0]))
            return $next($request);
        else
            return response()->json([
                'error' => 'Unauthenticated'
            ],401);
    }
}
