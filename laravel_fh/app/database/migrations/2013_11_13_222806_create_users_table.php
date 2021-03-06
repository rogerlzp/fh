<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	public function up()
	{
	    Schema::create('users', function($table)
	    {
	    	$table->engine = 'InnoDB';

	        $table->increments('id')->unsigned();
	        $table->string('email')->nullable();
	        $table->string('mobile')->nullable();
	        $table->string('photo')->nullable()->default(NULL);
	        $table->string('username');
	        $table->string('password');
	        $table->string('confirmation_code');
	        $table->string('remember_token')->nullable();
	        $table->boolean('confirmed')->default(false);
	        $table->boolean('is_admin')->default(0);
	        $table->boolean('is_online')->default(0); // 网上自己注册，还是我们导入到数据库的
	        
	        $table->unique( array('mobile','is_online'));
	        $table->unique( array('email','is_online'));
	        
	        $table->timestamps();
	        
	       
	    });
	}

	public function down()
	{
	    Schema::drop('users');
	}

}
