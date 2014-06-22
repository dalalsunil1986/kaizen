<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('location_id')->nullable();
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->boolean('free')->nullable();
            $table->string('price')->nullable();
            $table->integer('total_seats')->nullable();
            $table->integer('available_seats')->nullable();
            $table->string('slug')->nullable();
            $table->timestamp('date_start')->nullable(); // here also
            $table->timestamp('date_end')->nullable(); // just for now // later you make it date !!
            $table->integer('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('address_en')->nullable();
            $table->string('street')->nullable();
            $table->string('street_en')->nullable();
            $table->float('latitude',10,6)->nullable();
            $table->float('longitude',10,6)->nullable();
            $table->boolean('active')->nullable();
            $table->boolean('featured')->nullable();
            $table->string('button')->nullable();
            $table->string('button_en')->nullable();
            $table->timestamps();
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }

}
