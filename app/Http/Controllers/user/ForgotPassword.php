<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\PasswordResets;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;

class ForgotPassword extends Controller
{
    public function forgotPassword() {
        return view('auth.forgot-password');
    }
    public function forgetPasswordFormSubmit(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $email = $request->email;

        $token = Str::random(64);

        PasswordResets::updateOrCreate(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::to($email)->send(new ForgotPasswordMail($token));

        $lang = App::getLocale();

        $message = '';

        if($lang === 'en') {
            $message = 'Your password reset link has been sent via email!';
        }
        else {
            $message = 'Şifre sıfırlama bağlantısı email ile gönderilmiştir.';
        }

        return back()->with('message', $message);
    }
    public function resetPassword($token) {
        $data = PasswordResets::where('token', $token)
                                ->get();

        if(empty($data[0])){
            return redirect('/');
        }
        else {
            $date  = Carbon::now()->subMinutes( 60 );
            if($data[0]->created_at <= $date) {
                PasswordResets::where('created_at', '<=', $date)
                                ->where('token', $token)
                                ->delete();

                return redirect('/');
            }
            else {
                return view('auth.reset-password', [
                    'token' => $token,
                    'email' => $data[0]->email
                ]);
            }
        }
    }
    public function resetPasswordFormSubmit(Request $request) {
        $lang = App::getLocale();

        if($lang === 'en') {
            $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ]);
        }
        else {
            $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ],
                [
                    'password.required' => 'şifre mutlaka gereklidir.',
                    'password_confirmation.required' => 'şifre onaylama mutlaka gereklidir.',
                    'password.confirmed' => 'şifre onayı eşleşmiyor.'
                ]
            );
        }

        $email = $request->email;
        $password = $request->password;
        $token = $request->token;

        $updatePassword = PasswordResets::where([
                                                    'email' => $email,
                                                    'token' => $token
                                                ])
                                        ->first();

        if(!$updatePassword){
            $message = '';

            if($lang === 'en'){
                $message = 'Invalid token!';
            }
            else{
                $message = 'Tanımsız token!';
            }

            return back()->withInput()->with('error', $message);
        }

        User::where('email', $email)
                    ->update([
                        'password' => Hash::make($password)
                    ]);

        PasswordResets::where('email', $email)
                        ->delete();
        $url = '';
        $message = '';

        if($lang === 'en'){
            $url = '/login';
            $message = 'Your password has been successfully changed!';
        }
        else{
            $url = '/tr/giris';
            $message = 'Şifreniz başarıyla değiştirldi.';
        }

        return redirect($url)->with('message', $message);
    }
}
