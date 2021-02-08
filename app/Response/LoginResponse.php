<?php


namespace App\Response;


use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->isAdmin())
            return redirect('/admin/dashboard');

        \Illuminate\Support\Facades\Auth::logout();
        return redirect('login');
    }
}
