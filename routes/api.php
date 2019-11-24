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
    Route::get('/admin/users', 'Admin\LoginsController@index')->middleware(['scope:admin-users']);

    // Novo usuário
    Route::post('/admin/users', 'Admin\LoginsController@store')->middleware(['scope:admin-users']);

    // Edição de usuário
    Route::post('/admin/users/{id}', 'Admin\LoginsController@update')->middleware(['scope:admin-users']);

    // Exclusão de usuário
    Route::delete('/admin/users/{id}', 'Admin\LoginsController@destroy')->middleware(['scope:admin-users']);

    // Informações do usuário
    Route::get('/admin/users/{id}', 'Admin\LoginsController@show')->middleware(['scope:admin-users']);

    // Lista Grupos
    Route::get('/admin/groups/list', 'Admin\GroupsController@list')->middleware(['scope:admin-users']);

    // -------- USUÁRIOS & GRUPOS --------
    // Lista de usuários dos grupos
    Route::get('/admin/user-r-groups', 'Admin\UserRGroupsController@index')->middleware(['scope:admin-users']);

    // Novo usuário do grupo
    Route::post('/admin/user-r-groups', 'Admin\UserRGroupsController@store')->middleware(['scope:admin-users']);

    // Exclusão de função do grupo
    Route::delete('/admin/user-r-groups/{id}', 'Admin\UserRGroupsController@destroy')->middleware(['scope:admin-users']);


    // -------- GRUPOS --------
    // Lista de grupos
    Route::get('/admin/groups', 'Admin\GroupsController@index')->middleware(['scope:admin-groups']);

    // Novo grupo
    Route::post('/admin/groups', 'Admin\GroupsController@store')->middleware(['scope:admin-groups']);

    // Edição de grupo
    Route::post('/admin/groups/{id}', 'Admin\GroupsController@update')->middleware(['scope:admin-groups']);

    // Exclusão de grupo
    Route::delete('/admin/groups/{id}', 'Admin\GroupsController@destroy')->middleware(['scope:admin-groups']);

    // Informações do grupo
    Route::get('/admin/groups/{id}', 'Admin\GroupsController@show')->middleware(['scope:admin-groups']);

    // -------- GRUPOS & FUNÇÕES --------
    // Lista de funções dos grupos
    Route::get('/admin/group-r-roles', 'Admin\GroupRRolesController@index')->middleware(['scope:admin-groups']);

    // Nova função do grupo
    Route::post('/admin/group-r-roles', 'Admin\GroupRRolesController@store')->middleware(['scope:admin-groups']);

    // Exclusão de função do grupo
    Route::delete('/admin/group-r-roles/{id}', 'Admin\GroupRRolesController@destroy')->middleware(['scope:admin-groups']);

    // -------- FUNÇÕES --------
    // Lista de funções
    Route::get('/admin/roles', 'Admin\RolesController@index')->middleware(['scope:admin-roles']);

    // Lista de funções
    Route::get('/admin/roles/list', 'Admin\RolesController@list')->middleware(['scope:admin-roles']);

    // Nova função
    Route::post('/admin/roles', 'Admin\RolesController@store')->middleware(['scope:admin-roles']);

    // Edição de função
    Route::post('/admin/roles/{id}', 'Admin\RolesController@update')->middleware(['scope:admin-roles']);

    // Exclusão de função
    Route::delete('/admin/roles/{id}', 'Admin\RolesController@destroy')->middleware(['scope:admin-roles']);

    // Informações da função
    Route::get('/admin/roles/{id}', 'Admin\RolesController@show')->middleware(['scope:admin-roles']);

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

    // -------- PROFILE --------
    // Lista de perfil
    Route::get('/profile', 'ProfilesController@index');

    // Nova perfil
    Route::post('/profile', 'ProfilesController@store');

    // Edição de perfil
    Route::post('/profile/update', 'ProfilesController@update');

});

Route::post('/login', 'LoginController@loginOn');
Route::get('/status', 'LoginController@loginStatus');
/**
 * Funções de Usuário logado
 * Fim
 */



