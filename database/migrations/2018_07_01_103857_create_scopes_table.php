<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Scope;

class CreateScopesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scopes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('tag', 60)->unique();
            $table->string('title', 60);
            $table->text('description')->nullable();

            $table->timestamps();
        });

        // Define todas as funções do sistema
        Scope::create(['tag' => '*', 'title' => 'Developer', 'description' => 'Todas as funções do sistema']);

        // USUÁRIOS
        Scope::create(['tag' => 'users-index', 'title' => 'Lista de Usuários', 'description' => 'Lista os usuários do sistema.']);
        Scope::create(['tag' => 'users-store', 'title' => 'Cadastro de Usuários', 'description' => 'Registra um novo usuário no sistema.']);
        Scope::create(['tag' => 'users-update', 'title' => 'Atualização de Usuário', 'description' => 'Atualiza as informações do usuário.']);
        Scope::create(['tag' => 'users-destroy', 'title' => 'Exclusão de Usuário', 'description' => 'Remove definitivamente um usuário do sistema.']);
        Scope::create(['tag' => 'users-show', 'title' => 'Informações de Usuário', 'description' => 'Exibe as informações do usuário.']);

        // USUÁRIOS & GRUPOS
        Scope::create(['tag' => 'user-r-groups-index', 'title' => 'Lista de USUÁRIOS & GRUPOS', 'description' => 'Lista de relacionamento USUÁRIOS & GRUPOS']);
        Scope::create(['tag' => 'user-r-groups-store', 'title' => 'Cadastro de USUÁRIOS & GRUPOS', 'description' => 'Registra um novo relacionamento USUÁRIOS & GRUPOS.']);
        Scope::create(['tag' => 'user-r-groups-destroy', 'title' => 'Exclusão de USUÁRIOS & GRUPOS', 'description' => 'Remove definitivamente um relacionamento USUÁRIOS & GRUPOS do sistema.']);

        // GRUPOS
        Scope::create(['tag' => 'groups-index', 'title' => 'Lista de Grupos', 'description' => 'Lista os groupos do sistema.']);
        Scope::create(['tag' => 'groups-store', 'title' => 'Cadastro de Grupo', 'description' => 'Registra um novo groupo no sistema.']);
        Scope::create(['tag' => 'groups-update', 'title' => 'Atualização de Grupo', 'description' => 'Atualiza as informações do groupo.']);
        Scope::create(['tag' => 'groups-destroy', 'title' => 'Exclusão de Grupo', 'description' => 'Remove definitivamente um groupo do sistema.']);
        Scope::create(['tag' => 'groups-show', 'title' => 'Informações de Grupo', 'description' => 'Exibe as informações de groupo.']);

        // GRUPOS & FUNÇÕES
        Scope::create(['tag' => 'group-r-roles-index', 'title' => 'Lista de GRUPOS & FUNÇÕES', 'description' => 'Lista de relacionamento GRUPOS & FUNÇÕES']);
        Scope::create(['tag' => 'group-r-roles-store', 'title' => 'Cadastro de GRUPOS & FUNÇÕES', 'description' => 'Registra um novo relacionamento GRUPOS & FUNÇÕES']);
        Scope::create(['tag' => 'group-r-roles-destroy', 'title' => 'Exclusão de GRUPOS & FUNÇÕES', 'description' => 'Remove definitivamente um relacionamento GRUPOS & FUNÇÕES do sistema.']);

        // FUNÇÕES
        Scope::create(['tag' => 'roles-index', 'title' => 'Lista de Funções', 'description' => 'Lista os funções do sistema.']);
        Scope::create(['tag' => 'roles-store', 'title' => 'Cadastro de Função', 'description' => 'Registra um novo função no sistema.']);
        Scope::create(['tag' => 'roles-update', 'title' => 'Atualização de Função', 'description' => 'Atualiza as informações do função.']);
        Scope::create(['tag' => 'roles-destroy', 'title' => 'Exclusão de Função', 'description' => 'Remove definitivamente um função do sistema.']);
        Scope::create(['tag' => 'roles-show', 'title' => 'Informações de Função', 'description' => 'Exibe as informações de função.']);

        // FUNÇÕES & EXTENÇÕES
        Scope::create(['tag' => 'role-r-scopes-index', 'title' => 'Lista de FUNÇÕES & EXTENÇÕES', 'description' => 'Lista de relacionamento FUNÇÕES & EXTENÇÕES']);
        Scope::create(['tag' => 'role-r-scopes-store', 'title' => 'Cadastro de FUNÇÕES & EXTENÇÕES', 'description' => 'Registra um novo relacionamento FUNÇÕES & EXTENÇÕES.']);
        Scope::create(['tag' => 'role-r-scopes-destroy', 'title' => 'Exclusão de FUNÇÕES & EXTENÇÕES', 'description' => 'Remove definitivamente um relacionamento FUNÇÕES & EXTENÇÕES do sistema.']);

        // EXTENÇÕES
        Scope::create(['tag' => 'scopes-index', 'title' => 'Lista de Extenções', 'description' => 'Lista as Extenções do sistema.']);
        Scope::create(['tag' => 'scopes-store', 'title' => 'Cadastro de Extenção', 'description' => 'Registra uma nova Extenção no sistema.']);
        Scope::create(['tag' => 'scopes-update', 'title' => 'Atualização de Extenção', 'description' => 'Atualiza as informações da Extenção.']);
        Scope::create(['tag' => 'scopes-destroy', 'title' => 'Exclusão de Extenção', 'description' => 'Remove definitivamente uma Extenção do sistema.']);
        Scope::create(['tag' => 'scopes-show', 'title' => 'Informações de Extenção', 'description' => 'Exibe as informações da Extenção.']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scopes');
    }

}
