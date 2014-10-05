<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	public function up()
	{
	    Schema::create('users', function($table)
	    {
	    	$table->engine = 'InnoDB';

	        $table->increments('id')->unsigned();
	        $table->string('email')->unique();
	        $table->string('photo')->nullable()->default(NULL);
	        $table->string('username');
	        $table->string('password');
	        $table->string('confirmation_code');
	        $table->string('remember_token')->nullable();
	        $table->boolean('confirmed')->default(false);
	        $table->boolean('is_admin')->default(0);
	        $table->timestamps();
	        
	       
	    });
	}

	public function down()
	{
	    Schema::drop('users');
	}

}
