<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            /**General columns for all item types*/
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('title');
            $table->mediumText('description');
            $table->integer('user_id');
            $table->timestamps();

            /**Columns for movies*/
            $table->year('release_year')->nullable();
            $table->float('rating')->nullable();
            $table->integer('runtime')->nullable();
            $table->string('genre')->nullable();
            $table->string('director')->nullable();
            $table->mediumText('writers')->nullable();
            $table->string('actors')->nullable();
            $table->string('movie_cover')->nullable();

            /**Columns for books*/
            $table->string('writer')->nullable();
            $table->string('publisher')->nullable();
            $table->boolean('in_series')->nullable();
            $table->integer('number_in_series')->nullable();
            $table->string('book_cover')->nullable();

            /** Add the columns for additional items here*/

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
