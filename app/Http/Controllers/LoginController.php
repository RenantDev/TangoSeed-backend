<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    public function loginStatus (){
        if ($this->guard()->check()) {
            return response(['status' => true]);
        } else{
            return response(['status' => false]);
        }
    }

    public function logout(Request $request)
    {
        if (!$this->guard()->check()) {
            return response(['message' => 'No active user session was found'], 404);
        }
        $request->user('api')->token()->revoke();
        Auth::guard()->logout();
        Session::flush();
        Session::regenerate();
        return response(['message' => 'User was logged out']);
    }
}