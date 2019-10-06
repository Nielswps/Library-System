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

            /**Type of items. For more item types, simply add a new type to the array**/
            $table->enum('type', ['movie', 'book', 'cd']);

            $table->string('title');
            $table->mediumText('description');
            $table->json('meta')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('items');
    }
}
