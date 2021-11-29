<?php

namespace App\Actions\Jetstream;

use App\Models\UserInformations;
use Laravel\Jetstream\Contracts\DeletesUsers;
use App\Models\Cart;
use App\Models\Favorite;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        $userId = auth()->user()->id;

        Cart::where('user_id', $userId)
            ->delete();

        Favorite::where('user_id', $userId)
            ->delete();

        UserInformations::where('user_id', $userId)
            ->delete();

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
