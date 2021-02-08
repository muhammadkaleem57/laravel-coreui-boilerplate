<?php


namespace App\Actions;


use Illuminate\Support\Facades\Hash;

class AuthenticateLoginAttempt
{
    public function __invoke(\Illuminate\Http\Request $request){

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && $user->isAdmin() && $user->isAccountVerified() && $user->isActive() &&
            Hash::check($request->password, $user->password)) {
            return $user;
        }
    }
}
