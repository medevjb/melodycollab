<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{ 
    final public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    final public function callbackFromGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();

            // First its checking is user is exixts or not
            $is_user = User::where('email', $user->getEmail())->first();
            if(!$is_user){
                 // If user not exist, it will create a user in User table
                $saveUser = User::updateOrCreate(
                    [
                        'google_id' => $user->getId()
                    ],
                    [
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'password' => Hash::make($user->getName().'@'.$user->getId()),
                    ]
                );

            } else{
                // If user is exist, then it will update the existing user.
                User::where('email', $user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);

                $saveUser = User::where('email', $user->getEmail())->first();
            }

            Auth::loginUsingId($saveUser->id);
            return redirect()->route('producer.browse')->with(['t-success' => 'Successfully login with Google.']);


        } catch (\Throwable $th) {
            return redirect()->route('login')->with(['t-error' => 'Failed to login with Google.']);
        }

    }
}
