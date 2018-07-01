<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp;

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

    // Inicia uma nova sessão no sistema e retorna os tokens de acesso
    public function loginOn(Request $request){
        $http = new GuzzleHttp\Client;

        try{
            $token = DB::table('oauth_clients')->where('id', 1)->first();
            if($request->client_secret == $token->secret){
                $response = $http->post(env('APP_URL') . '/oauth/token', [
                    'form_params' => [
                        'username' => $request->username,
                        'password' => $request->password,
                        'client_id' => env('APP_PASSPORT_ID'),
                        'client_secret' => env('APP_PASSPORT_TOKEN'),
                        'grant_type' => 'password',
                        'scope' => '*',
                    ],
                ]);
            } else{
                $response = response(['error' => true, 'message' => __('auth.api_token_failed')], 404);
            }

        }catch (\Exception $e){
            $response = response(['error' => true, 'message' => __('auth.api_token_failed')], 404);
        }

        return $response;
    }

    // Verifica o status do usuário
    public function loginStatus()
    {
        if ($this->guard()->check()) {
            return response(['status' => true]);
        } else {
            return response(['status' => false]);
        }
    }

    // Sai do sistema
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