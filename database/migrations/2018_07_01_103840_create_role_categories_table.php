<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\RoleCategory;

class CreateRoleCategoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_categories', function(Blueprint $table) {
			$table->increments('id');

            $table->integer('ordination')->default(0);

			$table->string('title', 60)->unique();
			$table->string('slug', 60)->unique();
			$table->text('description')->nullable();
			
            $table->boolean('status')->default(true);
            
            $table->timestamps();
		});

		RoleCategory::create(['title' => 'category not defined', 'slug' => '*', 'description' => 'Sem descrição']);
		RoleCategory::create(['title' => 'Administrador', 'slug' => 'admin', 'description' => 'Funções administrativas']);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('role_categories');
	}

}
