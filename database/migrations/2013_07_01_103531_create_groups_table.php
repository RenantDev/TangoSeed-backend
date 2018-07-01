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

            $table->string('title', 60);
            $table->text('description');
            $table->boolean('status');

            $table->timestamps();
		});

		Group::create(['title' => 'none', 'description' => 'none', 'status' => true]);
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
