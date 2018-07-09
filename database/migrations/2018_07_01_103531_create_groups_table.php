<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Group;

class CreateGroupsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table) {
            $table->increments('id');

            $table->string('title', 60)->unique();
            $table->text('description');
            $table->boolean('status')->default(true);

            $table->timestamps();
		});

        Group::create(['title' => 'Developer', 'description' => 'Desenvolvedor do Sistema', 'status' => true]);
        Group::create(['title' => 'Administrador', 'description' => 'Administrador do Sistema', 'status' => true]);
        Group::create(['title' => 'Cliente', 'description' => 'Usuário comum do Sistema', 'status' => true]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groups');
	}

}
