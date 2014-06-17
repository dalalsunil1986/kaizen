<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locations', function(Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('country_id')->unsigned()->index();
			$table->integer('parent_id');
			$table->string('name');
			$table->string('name_en');
			$table->timestamps();
//            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('locations');
	}

}
