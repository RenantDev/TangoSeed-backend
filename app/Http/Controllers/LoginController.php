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

        // Lib de client HTTP
        $http = new GuzzleHttp\Client;

        // Validação de usuário
        try{
            // Verifica o token do frontend
            $token = DB::table('oauth_clients')->where('id', 1)->first();

            // Se o token do frontend estiver correto valida o usuário e retorna o token de acesso
            if($request->client_secret == $token->secret){
                // validação de dados de acesso
                $response = $http->post(env('APP_URL') . '/oauth/token', [
                    'form_params' => [
                        'username' => $request->username,
                        'password' => $request->password,
                        'client_id' => env('APP_PASSPORT_ID'),
                        'client_secret' => env('APP_PASSPORT_TOKEN'),
                        'grant_type' => 'password',
                        'scope' => $this->listScopes($request->username),
                    ],
                ]);
            } else{
                // Dados de acesso invalidos
                $response = response(['error' => true, 'message' => __('auth.failed')], 404);
            }

        }catch (\Exception $e){
            // Retorna um erro caso ocorra algum problema nas validações do try
            $response = response(['error' => true, 'message' => __('auth.failed')], 404);
        }

        return $response;
    }

    // Busca os scopes do usuário
    private function listScopes($email){
        // Busca os scopes do usuário no sistema e retorna um objeto
        $users = DB::table('users')->where('email', '=', $email)
            ->join('user_r_groups', 'users.id', '=', 'user_r_groups.user_id')
            ->join('groups', 'groups.id', '=', 'user_r_groups.group_id')
            ->where('groups.status', '=', 1)
            ->join('group_r_roles', 'group_r_roles.group_id', '=', 'groups.id')
            ->join('roles', 'roles.id', '=', 'group_r_roles.role_id')
            ->join('role_r_scopes', 'role_r_scopes.role_id', '=', 'roles.id')
            ->join('scopes', 'scopes.id', '=', 'role_r_scopes.scope_id')
            ->select('scopes.tag')
            ->get();

        // Converte o objeto em array
        $users = json_decode(json_encode($users), true);

        // Transforma a array em uma string
        $result = '';
        $i = 0;
        foreach($users as $user){
            $result = $result . $user['tag'] . ' ';
            $i++;
        }

        return $result;
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

    // Informações basicas do usuário
    public function info(){
        // Busca o avatar do usuário
        $profile = $this->profileValidate();

        // Converte o objeto em array
        $profileArray = json_decode(json_encode($profile), true);

        // Mescla a array do perfil com a array de login
        $profileArray = array_merge($profileArray[0], array('name' => Auth::user()->name));

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $profileArray,
                'menu' => $this->listMenu()
            ]);
        }
    }

    // Valida informações do perfil
    private function profileValidate(){
        $result = DB::table('profiles')
        ->where('user_id', '=', Auth::user()->id)
        ->select('avatar')
        ->get();

        if(!isset($result[0])){
            return [
                ['avatar' => 'default.png']
            ];
        }

        return $result;
    }

    // lista menu do usuario
    public function listMenu(){

        // Busca todas as categorias de menu
        $category = DB::table('role_categories')
        ->select('*')
        ->get();
        
        // Lista todos os itens que o usuario possui acesso
        $children = DB::table('users')->where('users.id', '=', Auth::user()->id)
        ->join('user_r_groups', 'users.id', '=', 'user_r_groups.user_id')
        ->join('groups', 'groups.id', '=', 'user_r_groups.group_id')
        ->where('groups.status', '=', 1)
        ->join('group_r_roles', 'group_r_roles.group_id', '=', 'groups.id')
        ->join('roles', 'roles.id', '=', 'group_r_roles.role_id')
        ->join('role_r_scopes', 'role_r_scopes.role_id', '=', 'roles.id')
        ->select(['roles.category_id', 'roles.title', 'roles.slug'])
        // ->select('*')
        ->get();

        // Define o menu do dashboard
        $menu = (array) [
            [
                'title' => 'Dashboard',
                'slug' => 'dashboard',
                'children' => null
            ]
        ];

        // Mescla as categorias e seus respectivos itens
        foreach ($category as $keyCategory => $valueCategory){
            foreach ($children as $keyChildren => $valueChildren){
                // Verifica se é um item ou uma categoria e mescla
                if($valueCategory->id == $valueChildren->category_id and $valueChildren->category_id == 1 ){
                    $menuMain = (array) [
                        'title' => $valueChildren->title,
                        'slug' => $valueChildren->slug,
                        'children' => null
                    ];
                    array_push($menu, $menuMain);
                } elseif($valueCategory->id == $valueChildren->category_id and $valueChildren->category_id != 1){
                    $menuMain = (array) [
                        'title' => $valueCategory->title,
                        'slug' => null,
                        'children' => (array) [
                            'title' => $valueChildren->title,
                            'slug' => $valueChildren->slug
                        ]
                    ];
                    array_push($menu, $menuMain);
                }
                    
            }
        }

        // Retorna o menu
        return json_decode(json_encode($menu), true);
    }

    // Sai do sistema
    public function logout()
    {
        try {
            // Verifica se o usuário esta logado
            if (!$this->guard()->check()) {
                // Retorna um erro caso o usuário não esteja logado
                return response(['error' => true, 'message' => __('auth.api_token_failed')], 404);
            } else {
                // Revoga o token de acesso
                $this->guard()->user()->token()->revoke();
                return response(['success' => true, 'message' => __('auth.api_token_logout')]);
            }
        } catch (\Exception $e) {
            // Retorna um erro caso ocorra algum problema nas validações do try
            return response(['error' => true, 'message' => __('auth.api_token_failed')], 404);
        }
    }
}