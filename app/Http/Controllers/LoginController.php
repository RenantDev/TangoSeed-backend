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

    public function loginStatus()
    {
        if ($this->guard()->check()) {
            return response(['status' => true]);
        } else {
            return response(['status' => false]);
        }
    }

    public function logout()
    {
        try {
            if (!$this->guard()->check()) {
                return response(['error' => true, 'message' => __('auth.api_token_failed')], 404);
            } else {
                $this->guard()->user()->token()->revoke();
                return response(['success' => true, 'message' => __('auth.api_token_logout')]);
            }
        } catch (\Exception $e) {
            return response(['error' => true, 'message' => __('auth.api_token_failed')], 404);
        }
    }
}