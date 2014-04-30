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
            $table->integer('location_id');
            $table->string('title');
            $table->string('title_en');
            $table->text('description');
            $table->text('description_en');
            $table->boolean('free');
            $table->string('price');
            $table->integer('total_seats');
            $table->integer('available_seats');
            $table->string('slug');
            $table->timestamp('date_start'); // here also
            $table->timestamp('date_end'); // just for now // later you make it date !!
            $table->integer('phone');
            $table->string('email');
            $table->text('address');
            $table->text('address_en');
            $table->string('street');
            $table->string('street_en');
            $table->float('latitude',10,6);
            $table->float('longitude',10,6);
            $table->boolean('active');
            $table->boolean('featured');
            $table->string('button');
            $table->string('button_en');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
