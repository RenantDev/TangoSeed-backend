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

            $table->string('title', 60)->unique();
            $table->text('description')->nullable();

            $table->timestamps();
		});


        Role::create(['title' => 'Developer', 'description' => 'Função para Desenvolvedor']);

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
