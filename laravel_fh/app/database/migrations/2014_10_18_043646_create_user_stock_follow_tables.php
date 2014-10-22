<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStockFollowTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_stock_follow', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
				
			$table->increments('id')->unsigned();
			$table->integer('stock_id')->unsigned();
			$table->integer('user_id')->unsigned();
				
		
			$table->timestamps();
				
			$table->foreign('stock_id')
			->references('id')->on('stock')
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
		Schema::table('user_stock_follow', function(Blueprint $table)
		{
			//
		});
	}

}
