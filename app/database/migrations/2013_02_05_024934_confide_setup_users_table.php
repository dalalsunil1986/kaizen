<?php
use Illuminate\Database\Migrations\Migration;

class ConfideSetupUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the users table
        Schema::create('users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('first_name');
            $table->string('second_name');
            $table->string('last_name');
            $table->integer('mobile');
            $table->integer('phone');
            $table->integer('country_id');
            $table->string('gender');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('google');
            $table->text('prev_event_comment');
            $table->string('confirmation_code');
            $table->boolean('confirmed')->default(false);
            $table->timestamps();
        });


        // Creates password reminders table
        Schema::create('password_reminders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('password_reminders');
        Schema::drop('users');
    }

}
