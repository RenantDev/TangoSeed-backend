<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['auth:api'])->group(function () {

    /**
     * Gerenciador de Usuários, Grupos, Funções e Extenções
     * Inicio
     */
    // -------- USUÁRIOS --------
    // Lista de Usuários
    Route::get('/admin/users', 'Admin\LoginsController@index')->middleware(['scope:users-index']);

    // Novo usuário
    Route::post('/admin/users', 'Admin\LoginsController@store')->middleware(['scope:users-store']);

    // Edição de usuário
    Route::post('/admin/users/{id}', 'Admin\LoginsController@update')->middleware(['scope:users-update']);

    // Exclusão de usuário
    Route::delete('/admin/users/{id}', 'Admin\LoginsController@destroy')->middleware(['scope:users-destroy']);

    // Informações do usuário
    Route::get('/admin/users/{id}', 'Admin\LoginsController@show')->middleware(['scope:users-show']);

    // -------- USUÁRIOS & GRUPOS --------
    // Lista de usuários dos grupos
    Route::get('/admin/user-r-groups', 'Admin\UserRGroupsController@index')->middleware(['scope:user-r-groups-index']);

    // Novo usuário do grupo
    Route::post('/admin/user-r-groups', 'Admin\UserRGroupsController@store')->middleware(['scope:user-r-groups-store']);

    // Edição de função do grupo
    Route::post('/admin/user-r-groups/{id}', 'Admin\UserRGroupsController@update')->middleware(['scope:user-r-groups-update']);

    // Exclusão de função do grupo
    Route::delete('/admin/user-r-groups/{id}', 'Admin\UserRGroupsController@destroy')->middleware(['scope:user-r-groups-destroy']);

    // Informações da função do grupo
    Route::get('/admin/user-r-groups/{id}', 'Admin\UserRGroupsController@show')->middleware(['scope:user-r-groups-show']);

    // -------- GRUPOS --------
    // Lista de grupos
    Route::get('/admin/groups', 'Admin\GroupsController@index')->middleware(['scope:groups-index']);

    // Novo grupo
    Route::post('/admin/groups', 'Admin\GroupsController@store')->middleware(['scope:groups-store']);

    // Edição de grupo
    Route::post('/admin/groups/{id}', 'Admin\GroupsController@update')->middleware(['scope:groups-update']);

    // Exclusão de grupo
    Route::delete('/admin/groups/{id}', 'Admin\GroupsController@destroy')->middleware(['scope:groups-destroy']);

    // Informações do grupo
    Route::get('/admin/groups/{id}', 'Admin\GroupsController@show')->middleware(['scope:groups-show']);

    // -------- GRUPOS & FUNÇÕES --------
    // Lista de funções dos grupos
    Route::get('/admin/group-r-roles', 'Admin\GroupRRolesController@index')->middleware(['scope:group-r-roles-index']);

    // Nova função do grupo
    Route::post('/admin/group-r-roles', 'Admin\GroupRRolesController@store')->middleware(['scope:group-r-roles-store']);

    // Edição de função do grupo
    Route::post('/admin/group-r-roles/{id}', 'Admin\GroupRRolesController@update')->middleware(['scope:group-r-roles-update']);

    // Exclusão de função do grupo
    Route::delete('/admin/group-r-roles/{id}', 'Admin\GroupRRolesController@destroy')->middleware(['scope:group-r-roles-destroy']);

    // Informações da função do grupo
    Route::get('/admin/group-r-roles/{id}', 'Admin\GroupRRolesController@show')->middleware(['scope:group-r-roles-show']);

    // -------- FUNÇÕES --------
    // Lista de funções
    Route::get('/admin/roles', 'Admin\RolesController@index')->middleware(['scope:roles-index']);

    // Nova função
    Route::post('/admin/roles', 'Admin\RolesController@store')->middleware(['scope:roles-store']);

    // Edição de função
    Route::post('/admin/roles/{id}', 'Admin\RolesController@update')->middleware(['scope:roles-update']);

    // Exclusão de função
    Route::delete('/admin/roles/{id}', 'Admin\RolesController@destroy')->middleware(['scope:roles-destroy']);

    // Informações da função
    Route::get('/admin/roles/{id}', 'Admin\RolesController@show')->middleware(['scope:roles-show']);

    // -------- FUNÇÕES & EXTENÇÕES --------
    // Lista de extenções das funções
    Route::get('/admin/role-r-scopes', 'Admin\RoleRScopesController@index')->middleware(['scope:role-r-scopes-index']);

    // Nova extenção da função
    Route::post('/admin/role-r-scopes', 'Admin\RoleRScopesController@store')->middleware(['scope:role-r-scopes-store']);

    // Edição de extenção da função
    Route::post('/admin/role-r-scopes/{id}', 'Admin\RoleRScopesController@update')->middleware(['scope:role-r-scopes-update']);

    // Exclusão de extenção da função
    Route::delete('/admin/role-r-scopes/{id}', 'Admin\RoleRScopesController@destroy')->middleware(['scope:role-r-scopes-destroy']);

    // Informações da extenção da função
    Route::get('/admin/role-r-scopes/{id}', 'Admin\RoleRScopesController@show')->middleware(['scope:role-r-scopes-show']);

    // -------- EXTENÇÕES --------
    // Lista de extenções
    Route::get('/admin/scopes', 'Admin\ScopesController@index')->middleware(['scope:scopes-index']);

    // Nova extenção
    Route::post('/admin/scopes', 'Admin\ScopesController@store')->middleware(['scope:scopes-store']);

    // Edição de extenção
    Route::post('/admin/scopes/{id}', 'Admin\ScopesController@update')->middleware(['scope:scopes-update']);

    // Exclusão de extenção
    Route::delete('/admin/scopes/{id}', 'Admin\ScopesController@destroy')->middleware(['scope:scopes-destroy']);

    // Informações da extenção
    Route::get('/admin/scopes/{id}', 'Admin\ScopesController@show')->middleware(['scope:scopes-show']);

    /**
     * Gerenciador de Usuários, Grupos, Funções e Extenções
     * Fim
     */
});

/**
 * Funções de Usuário logado
 * Inicio
 */
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', 'LoginController@logout');
    Route::get('/user', 'LoginController@info');
});

Route::post('/login', 'LoginController@loginOn');
Route::get('/status', 'LoginController@loginStatus');
/**
 * Funções de Usuário logado
 * Fim
 */



