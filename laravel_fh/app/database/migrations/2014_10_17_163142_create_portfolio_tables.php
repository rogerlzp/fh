<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portfolio', function(Blueprint $table)
		{	
			$table->engine = 'InnoDB';
				
			$table->increments('id')->unsigned();
			$table->string('name', 140);
			$table->string('slug')->unique();
			$table->text('description')->nullable()->default(NULL);
			$table->integer('vote_cache')->unsigned()->default(0);
			$table->integer('view_cache')->unsigned()->default(0);
			$table->integer('user_id')->unsigned();
			$table->float('return_rate')->nullable()->default(0);
			$table->integer('fee')->default(0);
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
		Schema::table('portfolio', function(Blueprint $table)
		{
			//
		});
	}

}
