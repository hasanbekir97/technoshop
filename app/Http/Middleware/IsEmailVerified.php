<?php

namespace App\Http\Middleware;

use App\Mail\VerifyMail;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class IsEmailVerified
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
        $user_id = auth()->user()->id;

        $userControl = User::where('id', $user_id)
                            ->get();

        if($userControl[0]->email_verified_at === 'null' || $userControl[0]->email_verified_at === '' || $userControl[0]->email_verified_at === null) {
            return redirect()->route('email-verify');
        }
        else {
            return $next($request);
        }
    }
}
