<?php

namespace App\Http\Controllers\pages;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Admins;
use Illuminate\Support\Facades\Mail;

class Contacts extends Controller
{
    public function index(){
        return view('pages.contact');
    }
    public function contactFormSubmit(Request $request){
        $lang = $request->lang;

        if($lang === 'en') {
            $request->validate([
               'name' => ['required', 'string'],
               'email' => ['required', 'email'],
               'message' => ['required', 'string'],
                'agree' => 'required'
            ],
                [
                    'name.required' => 'Please enter your name.',
                    'email.required' => 'Please enter your email address.',
                    'email.email' => 'Please enter a valid email address.',
                    'message.required' => 'Please enter your message.',
                    'agree.required' => 'Please confirm this area.'
                ]
            );
        }
        else {
            $request->validate([
               'name' => ['required', 'string'],
               'email' => ['required', 'email'],
               'message' => ['required', 'string'],
                'agree' => 'required'
            ],
                [
                    'name.required' => 'Lütfen isminizi giriniz.',
                    'email.required' => 'Lütfen email addresinizi giriniz.',
                    'email.email' => 'Lütfen tanımlı bir email adresi giriniz.',
                    'message.required' => 'Lütfen mesajınızı giriniz.',
                    'agree.required' => 'Lütfen bu alanı onaylayınız.'
                ]
            );
        }

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $message = $request->message;

        if($phone === null)
            $phone = '';

        $contact = new Contact();
        $contact->name = $name;
        $contact->email = $email;
        $contact->phone = $phone;
        $contact->message = $message;
        $contact->save();

        $emailAdmin = Admins::select('email')
                            ->get();

        $details = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message
        ];

        Mail::to($emailAdmin[0]->email)->send(new ContactMail($details));

        return response()->json([
            'status' => 'successful'
        ]);

    }
}
