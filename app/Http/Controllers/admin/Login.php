<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

class Login extends Controller
{
    public function index(){
        if(Session::get('AuthAdmin') === true)
            return redirect('/admin/dashboard');
        else
            return view('admin.login');
    }
    public function login(Request $request){

        $inputVal = $request->all();

        $validator = Validator::make($inputVal, [
            'email'  => ['required', 'email'],
            'password'  => ['required'],
        ],
            [
                'email.email'=> 'Please enter a valid email address',
                'email.required'=> 'Please enter your email address',
                'password.required'=> 'Please enter your password.',
            ]
        );

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->email;
        $password = $request->password;

        $admin = Admin::get();

        $admin_email = $admin[0]->email;
        $admin_password = $admin[0]->password;

        if($email != $admin_email || Hash::check($password, $admin_password) === false){
            return redirect()->back()->with('message','You entered the information incorrectly. Please try again.');
        }else{
            Session::put('AuthAdmin', true);
            return redirect('/admin/dashboard');
        }
    }
    public function logout(){
        Session::put('AuthAdmin', false);
        return redirect('/admin/login');
    }
}
