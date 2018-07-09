<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\GroupRRole;

class CreateGroupRRolesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_r_roles', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');

            // Evita a duplicidade de funções em um grupo
            $table->unique(['group_id', 'role_id']);

            $table->timestamps();
		});

        GroupRRole::create(['group_id' => 1, 'role_id' => 1]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_r_roles');
	}

}
