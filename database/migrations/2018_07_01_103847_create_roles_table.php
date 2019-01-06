<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Role;

class CreateRolesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table) {
			$table->increments('id');

            $table->integer('ordination')->default(0);

			$table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');

            $table->string('icon', 60)->default('fa-home');
            $table->string('title', 60);
            $table->string('slug', 60)->unique();
			$table->text('description')->nullable();
			
            $table->boolean('status')->default(true);

            $table->timestamps();
		});

		
		Role::create(['category_id' => 1, 'icon' => '', 'title' => 'none', 'slug' => '#', 'description' => 'none']);
		Role::create(['category_id' => 1, 'icon' => 'fa-home', 'title' => 'Resumo Dev', 'slug' => 'resumo-dev', 'description' => 'Função para Desenvolvedor']);

		Role::create(['category_id' => 1, 'icon' => 'fa-gears', 'title' => 'Administrador', 'slug' => 'admin', 'description' => 'Administração do sistema.']);
		
        Role::create(['category_id' => 3, 'icon' => '', 'title' => 'Usuários', 'slug' => 'users', 'description' => 'Gerenciador de usuários do sistema']);
        Role::create(['category_id' => 3, 'icon' => '', 'title' => 'Grupos', 'slug' => 'groups', 'description' => 'Gerenciador de grupos do sistema']);
        Role::create(['category_id' => 3, 'icon' => '', 'title' => 'Funções', 'slug' => 'roles', 'description' => 'Gerenciador de funções do sistema']);
        Role::create(['category_id' => 3, 'icon' => '', 'title' => 'Extenções', 'slug' => 'scopes', 'description' => 'Gerenciador de extenções do sistema']);
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}

}
