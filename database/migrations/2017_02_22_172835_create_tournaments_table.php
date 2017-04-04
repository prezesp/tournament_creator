<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->increments('id')->unsigned();
          $table->string('name');
          $table->string('description');
          $table->date('date');
          $table->string('type');
          $table->integer('seeds');
          $table->double('win_pts')->nullable();
          $table->double('draw_pts')->nullable();
          $table->double('loss_pts')->nullable();
          $table->timestamps();

          // user as owner
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
