<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\RoleRScope;

class CreateRoleRScopesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_r_scopes', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('scope_id')->unsigned();
            $table->foreign('scope_id')->references('id')->on('scopes')->onDelete('cascade')->onUpdate('cascade');

            // Evita a duplicidade de extenções
            $table->unique(['role_id', 'scope_id']);

            $table->timestamps();
		});

		RoleRScope::create(['role_id' => 2, 'scope_id' => 1]);
		
		// Usuários
        RoleRScope::create(['role_id' => 4, 'scope_id' => 2]);
        RoleRScope::create(['role_id' => 4, 'scope_id' => 3]);
        RoleRScope::create(['role_id' => 4, 'scope_id' => 4]);
        RoleRScope::create(['role_id' => 4, 'scope_id' => 5]);
        RoleRScope::create(['role_id' => 4, 'scope_id' => 6]);
        RoleRScope::create(['role_id' => 4, 'scope_id' => 7]);
        RoleRScope::create(['role_id' => 4, 'scope_id' => 8]);
		RoleRScope::create(['role_id' => 4, 'scope_id' => 9]);
        RoleRScope::create(['role_id' => 4, 'scope_id' => 31]);
		
		// Grupos
        RoleRScope::create(['role_id' => 5, 'scope_id' => 10]);
        RoleRScope::create(['role_id' => 5, 'scope_id' => 11]);
        RoleRScope::create(['role_id' => 5, 'scope_id' => 12]);
        RoleRScope::create(['role_id' => 5, 'scope_id' => 13]);
        RoleRScope::create(['role_id' => 5, 'scope_id' => 14]);
        RoleRScope::create(['role_id' => 5, 'scope_id' => 15]);
        RoleRScope::create(['role_id' => 5, 'scope_id' => 16]);
		RoleRScope::create(['role_id' => 5, 'scope_id' => 17]);
		
		// Funções
        RoleRScope::create(['role_id' => 6, 'scope_id' => 18]);
        RoleRScope::create(['role_id' => 6, 'scope_id' => 19]);
        RoleRScope::create(['role_id' => 6, 'scope_id' => 20]);
        RoleRScope::create(['role_id' => 6, 'scope_id' => 21]);
        RoleRScope::create(['role_id' => 6, 'scope_id' => 22]);
        RoleRScope::create(['role_id' => 6, 'scope_id' => 23]);
        RoleRScope::create(['role_id' => 6, 'scope_id' => 24]);
		RoleRScope::create(['role_id' => 6, 'scope_id' => 25]);
		
		// Extenções
        RoleRScope::create(['role_id' => 7, 'scope_id' => 26]);
        RoleRScope::create(['role_id' => 7, 'scope_id' => 27]);
        RoleRScope::create(['role_id' => 7, 'scope_id' => 28]);
        RoleRScope::create(['role_id' => 7, 'scope_id' => 29]);
        RoleRScope::create(['role_id' => 7, 'scope_id' => 30]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('role_r_scopes');
	}

}
