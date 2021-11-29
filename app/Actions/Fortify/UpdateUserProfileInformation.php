<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use App\Models\UserInformations;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        $lang = App::getLocale();

        if($lang === 'en') {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone' => 'nullable',
                'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ],
                [
                    'name.required' => 'Please enter your name.',
                    'email.required' => 'Please enter your email address.',
                    'email.email' => 'Please enter a valid email address.'
                ]
            )->validateWithBag('updateProfileInformation');
        }
        else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone' => 'nullable',
                'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ],
                [
                    'name.required' => 'Lütfen isminizi giriniz.',
                    'name.max' => 'İsim Soyisim alanı en fazla 255 karakter olabilir.',
                    'email.required' => 'Lütfen email addresinizi giriniz.',
                    'email.email' => 'Lütfen tanımlı bir email adresi giriniz.'
                ]
            )->validateWithBag('updateProfileInformation');
        }


        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }


        if(isset($input['phone'])) {
            $user_id = auth()->user()->id;

            $userInformation = UserInformations::where('user_id', $user_id)
                ->get();

            if (count($userInformation) > 0) {
                UserInformations::where('user_id', $user_id)
                    ->update([
                        'phone' => $input['phone']
                    ]);
            } else {
                $userInformations = new UserInformations();
                $userInformations->user_id = $user_id;
                $userInformations->phone = $input['phone'];
                $userInformations->save();
            }
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
