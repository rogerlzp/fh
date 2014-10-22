<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPortfolioFollowTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_portfolio_follow', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id')->unsigned();
			$table->integer('portfolio_id')->unsigned();
			$table->integer('user_id')->unsigned();
			
			
			$table->timestamps();
			
			$table->foreign('portfolio_id')
			->references('id')->on('portfolio')
			->onUpdate('cascade')
			->onDelete('cascade');
			
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
		Schema::table('user_portfolio_follow', function(Blueprint $table)
		{
			//
		});
	}

}
