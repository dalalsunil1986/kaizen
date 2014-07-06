<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('types', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('fee_type')->nullable(); // [Free, Paid]
            $table->string('approval_type')->nullable(); // [CONFIRM,DIRECT]
            $table->string('registration_type')->nullable(); // [VIP, ONLINE]
            $table->morphs('settable'); // [Event,Package]
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
		Schema::drop('types');
	}

}
