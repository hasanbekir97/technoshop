<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class Api extends Controller
{
    public function generateApiKey(Request $request){
        $user_id = auth()->user()->id;

        $api_key = Str::random(60);

        User::where('id', $user_id)
            ->update([
                'api_token' => $api_key
            ]);

        return response()->json([
            'api_key' => $api_key
        ]);
    }
    public function showApiKey(Request $request){
        $user_id = auth()->user()->id;

        $data = User::where('id', $user_id)
                    ->get('api_token');

        $api_key = $data[0]->api_token;

        return response()->json([
            'api_key' => $api_key
        ]);
    }
}
