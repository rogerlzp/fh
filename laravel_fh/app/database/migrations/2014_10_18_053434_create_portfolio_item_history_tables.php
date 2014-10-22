<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioItemHistoryTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portfolio_history_item', function(Blueprint $table)
		{

			$table->engine = 'InnoDB';
				
			$table->increments('id')->unsigned();
			$table->integer('portfolio_item_id')->unsigned();

			$table->dateTime('sold_time');
			$table->integer('sold_quantity');
			$table->decimal('sold_price', 8,4);

			$table->timestamps();
				
			$table->foreign('portfolio_item_id')
			->references('id')->on('portfolio_item')
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
		Schema::table('portfolio_item_history', function(Blueprint $table)
		{
			//
		});
	}

}
