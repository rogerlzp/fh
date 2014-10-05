<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activity', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id')->unsigned();
			$table->string('title', 140);
			$table->string('slug')->unique();
			$table->text('description')->nullable()->default(NULL);
			$table->boolean('isover')->default(false);
			$table->integer('vote_cache')->unsigned()->default(0);
			$table->integer('view_cache')->unsigned()->default(0);
			$table->integer('user_id')->unsigned();
			$table->string('topic');
			$table->dateTime('startDate');
			$table->dateTime('endDate');
			$table->string('address');
			$table->dateTime('join_endtime');
			$table->integer('fee');
			$table->string('traffic');
			$table->string('yy');
			$table->string('note');
			
			$table->timestamps();
			
			$table->foreign('user_id')
			->references('id')->on('users')
			->onUpdate('cascade')
			->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	 Schema::table('activity', function($table)
        {
            $table->dropForeign('activity_user_id_foreign');
        });

        Schema::drop('activity');
	}

}
