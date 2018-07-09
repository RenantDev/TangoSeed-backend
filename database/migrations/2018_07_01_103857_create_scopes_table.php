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
            $table->text('description');

            $table->timestamps();
        });

        Scope::create(['tag' => '*', 'title' => 'Developer', 'description' => 'Todas as funções do sistema']);
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
