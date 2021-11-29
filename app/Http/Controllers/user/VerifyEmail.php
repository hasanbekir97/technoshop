<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\EmailVerify;
use App\Models\PasswordResets;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;
use App\Mail\VerifyMail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmail extends Controller
{
    public function index(){
        $email = auth()->user()->email;
        $user_id = auth()->user()->id;

        $userControl = User::where('id', $user_id)
            ->get();

        if($userControl[0]->email_verified_at === 'null' || $userControl[0]->email_verified_at === '' || $userControl[0]->email_verified_at === null) {
            $url = URL::temporarySignedRoute(
                'verification.verify',
                \Illuminate\Support\Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $user_id,
                    'hash' => sha1($email),
                ]
            );

            Mail::to($email)->send(new VerifyMail($url));
        }
        return view('auth.verify-email');
    }
    public function sendVerificationEmail(Request $request) {
        $email = auth()->user()->email;
        $user_id = auth()->user()->id;

        $userControl = User::where('id', $user_id)
                            ->get();

        if($userControl[0]->email_verified_at === 'null' || $userControl[0]->email_verified_at === '' || $userControl[0]->email_verified_at === null) {
            $url = URL::temporarySignedRoute(
                'verification.verify',
                \Illuminate\Support\Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $user_id,
                    'hash' => sha1($email),
                ]
            );

            Mail::to($email)->send(new VerifyMail($url));

            $message = 'Your email verification link has been sent via email!';

            return back()->with('message', $message);
        }
        else{
            $lang = App::getLocale();

            if($lang === 'en')
                $url = '/';
            else
                $url = '/tr';

            return redirect($url);
        }
    }
    public function verificationVerify(EmailVerificationRequest $request) {
        $request->fulfill();

        $lang = App::getLocale();
        $url = '';

        if($lang === 'en')
            $url = '/';
        else
            $url = '/tr';

        return redirect($url);
    }
    public function showEmailVerificationResult(Request $request){
        $user_id = auth()->user()->id;

        $userControl = User::where('id', $user_id)
                            ->get();

        if($userControl[0]->email_verified_at === 'null' || $userControl[0]->email_verified_at === '' || $userControl[0]->email_verified_at === null) {
            $result = 0;
        }
        else{
            $result = 1;
        }

        return response()->json([
            'result' => $result
        ]);
    }
}
