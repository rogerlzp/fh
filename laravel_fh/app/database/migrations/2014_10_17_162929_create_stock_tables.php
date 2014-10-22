<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';			
			$table->increments('id')->unsigned();
			$table->string('name', 140);
			$table->string('slug')->unique();
			$table->string('code')->unique();
			$table->integer('vote_cache')->unsigned()->default(0);
			$table->integer('view_cache')->unsigned()->default(0);
		
			$table->decimal('current_price')->nullable()->default(0);
			$table->timestamps();
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('stock', function(Blueprint $table)
		{
			//
		});
	}

}
