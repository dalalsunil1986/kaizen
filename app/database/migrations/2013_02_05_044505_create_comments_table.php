<?php

use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the `Comments` table
		Schema::create('comments', function($table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
            $table->morphs('commentable');
			$table->text('content');
			$table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Delete the `Comments` table
		Schema::drop('comments');
	}

}
