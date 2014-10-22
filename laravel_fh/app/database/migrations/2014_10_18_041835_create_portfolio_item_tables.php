<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioItemTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portfolio_item', function(Blueprint $table)
		{
			
			$table->engine = 'InnoDB';
			
			$table->increments('id')->unsigned();
			$table->string('stock_code');
			$table->integer('portfolio_id')->unsigned();
			
			$table->decimal('current_price', 8,4);
			
			$table->dateTime('buy_time');
			$table->integer('buy_quantity');
			$table->decimal('buy_price', 8,4);
			
			$table->timestamps();
			
			$table->foreign('stock_code')
			->references('code')->on('stock')
			->onUpdate('cascade')
			->onDelete('cascade');
			
			$table->foreign('portfolio_id')
			->references('id')->on('portfolio')
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
		Schema::table('portfolio_item', function(Blueprint $table)
		{
			//
		});
	}

}
