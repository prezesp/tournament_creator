<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->enum('stage', array('g', 'qt', 'sf', 'f', '3rd'));
            // quarterfinals, semifinals, final, 3rdmatch
            $table->timestamps();

            $table->integer('home_id')->unsigned()->nullable();
            $table->foreign('home_id')->references('id')->on('teams');
            $table->integer('away_id')->unsigned()->nullable();
            $table->foreign('away_id')->references('id')->on('teams');

            $table->integer('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups');

            $table->integer('tournament_id')->unsigned()->nullable();
            $table->foreign('tournament_id')->references('id')->on('tournaments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
