<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function loginOn(Request $request)
    {

        // Lib de client HTTP
        $http = new GuzzleHttp\Client;

        // Validação de usuário
        try {
            // Verifica o token do frontend
            $token = DB::table('oauth_clients')->where('id', 1)->first();

            // Se o token do frontend estiver correto valida o usuário e retorna o token de acesso
            if ($request->client_secret == $token->secret) {
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
            } else {
                // Dados de acesso invalidos
                $response = response(['error' => true, 'message' => __('auth.failed')], 404);
            }

        } catch (\Exception $e) {
            // Retorna um erro caso ocorra algum problema nas validações do try
            $response = response(['error' => true, 'message' => __('auth.failed')], 404);
        }

        return $response;
    }

    // Busca os scopes do usuário
    private function listScopes($email)
    {
        // Busca os scopes do usuário no sistema e retorna um objeto
        $users = DB::table('users')->where('email', '=', $email)
            ->join('user_r_groups', 'users.id', '=', 'user_r_groups.user_id')
            ->join('groups', 'groups.id', '=', 'user_r_groups.group_id')
            ->where('groups.status', '=', 1)
            ->join('group_r_roles', 'group_r_roles.group_id', '=', 'groups.id')
            ->join('roles', 'roles.id', '=', 'group_r_roles.role_id')
            ->where('roles.status', '=', 1)
            ->where('roles.id', '!=', 1)
            ->join('role_r_scopes', 'role_r_scopes.role_id', '=', 'roles.id')
            ->join('scopes', 'scopes.id', '=', 'role_r_scopes.scope_id')
            ->select('scopes.tag')
            ->groupBy('scopes.tag')
            ->get();

        // Converte o objeto em array
        $users = json_decode(json_encode($users), true);

        // Transforma a array em uma string
        $result = '';
        $i = 0;
        foreach ($users as $user) {
            if ($user['tag'] == '*') {
                $result = '*';
                continue;
            } else {
                $result = $result . $user['tag'] . ' ';
            }
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
    public function info()
    {
        // Busca o avatar do usuário
        $profile = $this->profileValidate();

        // Converte o objeto em array
        $profileArray = json_decode(json_encode($profile), true);

        // Mescla a array do perfil com a array de login
        $profileArray = array_merge($profileArray[0], array('name' => Auth::user()->name));

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $profileArray,
                'menu' => $this->listMenu(),
            ]);
        }
    }

    // Valida informações do perfil
    private function profileValidate()
    {
        $result = DB::table('profiles')
            ->where('user_id', '=', Auth::user()->id)
            ->select('avatar')
            ->get();

        if (!isset($result[0])) {
            return [
                ['avatar' => 'default.png'],
            ];
        }

        return $result;
    }

    // lista menu do usuario
    public function listMenu()
    {
        
        // Verifica a existencia de um login Developer
        $developerGroup = DB::table('users')->where('users.id', '=', Auth::user()->id)
            ->join('user_r_groups', 'users.id', '=', 'user_r_groups.user_id')
            ->join('groups', 'groups.id', '=', 'user_r_groups.group_id')
            ->where('groups.id', '=', 1)->exists();

        if ($developerGroup) {
            // Lista todas as categorias
            $mainRoles = DB::table('roles')
                ->where('roles.category_id', '=', 1)
                ->where('roles.id', '!=', 1)
                ->select(['roles.id', 'roles.ordination', 'roles.category_id', 'roles.icon', 'roles.title', 'roles.slug'])
                ->groupBy('roles.title')
                ->orderBy('roles.ordination')
                ->get();

            // Lista todos os itens
            $roles = DB::table('roles')
                ->where('roles.category_id', '!=', 1)
                ->select(['roles.id', 'roles.ordination', 'roles.category_id', 'roles.icon', 'roles.title', 'roles.slug'])
                ->groupBy('roles.title')
                ->orderBy('roles.ordination')
                ->get();
        } else {
            // Lista todas as categorias
            $mainRoles = DB::table('users')->where('users.id', '=', Auth::user()->id)
                ->join('user_r_groups', 'users.id', '=', 'user_r_groups.user_id')
                ->join('groups', 'groups.id', '=', 'user_r_groups.group_id')
                ->where('groups.status', '=', 1)
                ->join('group_r_roles', 'group_r_roles.group_id', '=', 'groups.id')
                ->join('roles', 'roles.id', '=', 'group_r_roles.role_id')
                ->where('roles.category_id', '=', 1)
                ->where('roles.id', '!=', 1)
                ->where('roles.status', '=', 1)
                ->select(['roles.id', 'roles.ordination', 'roles.category_id', 'roles.icon', 'roles.title', 'roles.slug'])
                ->groupBy('roles.title')
                ->orderBy('roles.ordination')
                ->get();

            // Lista todos os itens
            $roles = DB::table('users')->where('users.id', '=', Auth::user()->id)
                ->join('user_r_groups', 'users.id', '=', 'user_r_groups.user_id')
                ->join('groups', 'groups.id', '=', 'user_r_groups.group_id')
                ->where('groups.status', '=', 1)
                ->join('group_r_roles', 'group_r_roles.group_id', '=', 'groups.id')
                ->join('roles', 'roles.id', '=', 'group_r_roles.role_id')
                ->where('roles.category_id', '!=', 1)
                ->where('roles.status', '=', 1)
                ->select(['roles.id', 'roles.ordination', 'roles.category_id', 'roles.icon', 'roles.title', 'roles.slug'])
                ->groupBy('roles.title')
                ->orderBy('roles.ordination')
                ->get();
        }


        // Define o menu do dashboard
        $menu = (array) [
            [
                'icon' => 'fa-home',
                'title' => 'Dashboard',
                'slug' => 'dashboard',
                'children' => array(),
            ],
        ];

        // Lista itens do menu
        $menuMain = array();
        foreach ($mainRoles as $mainKey => $mainRole) {
            // Define sub menu
            $menuRole = array();
            foreach ($roles as $key => $role) {
                if($mainRole->id == $role->category_id){
                    $newRole = (array) [
                        'icon' => $role->icon,
                        'title' => $role->title,
                        'slug' => $role->slug,
                        //'slug' => $mainRole->slug.'/'.$role->slug,
                    ];
    
                    // adiciona um novo role a categoria
                    array_push($menuRole, $newRole);
                }
            }

            // Define menu ou categoria
            $menuMain = (array) [
                'icon' => $menuMain->icon,
                'title' => $mainRole->title,
                'slug' => $mainRole->slug,
                'children' => $menuRole,
            ];

            // Adiciona um novo role principal ao menu
            array_push($menu, $menuMain);
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
