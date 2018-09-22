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

			$table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('role_categories')->onDelete('cascade')->onUpdate('cascade');

            $table->string('title', 60);
            $table->string('slug', 60)->unique();
            $table->text('description')->nullable();

            $table->timestamps();
		});

		
        Role::create(['category_id' => 1,'title' => 'Resumo Dev', 'slug' => 'resumo-dev', 'description' => 'Função para Desenvolvedor']);

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
