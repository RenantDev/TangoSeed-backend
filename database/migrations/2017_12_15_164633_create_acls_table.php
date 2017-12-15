<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('grupo_funcoes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('titulo', 100);
            $table->text('descricao');
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });

        Schema::create('grupos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('titulo', 100);
            $table->text('descricao');
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });

        Schema::create('funcoes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('titulo', 100);
            $table->text('descricao');
            $table->string('slug', 100);
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });

        Schema::create('login_r_grupo', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('grupo_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });


        Schema::create('grupo_r_grupo_funcao', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('grupo_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('grupo_funcoes_id')->unsigned();
            $table->foreign('grupo_funcoes_id')->references('id')->on('grupo_funcoes')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });


        Schema::create('login_r_grupo_funcao', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('grupo_funcoes_id')->unsigned();
            $table->foreign('grupo_funcoes_id')->references('id')->on('grupo_funcoes')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });

        Schema::create('grupo_funcao_r_funcao', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('grupo_funcoes_id')->unsigned();
            $table->foreign('grupo_funcoes_id')->references('id')->on('grupo_funcoes')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('funcao_id')->unsigned();
            $table->foreign('funcao_id')->references('id')->on('funcoes')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_r_grupo');
        Schema::dropIfExists('login_r_grupo_funcao');
        Schema::dropIfExists('grupo_funcao_r_funcao');
        Schema::dropIfExists('grupo_r_grupo_funcao');
        Schema::dropIfExists('grupo_funcoes');
        Schema::dropIfExists('funcoes');
        Schema::dropIfExists('grupos');
    }
}

