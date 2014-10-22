<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->decimal('balance', 8, 4)->default(0);
			$table->decimal('original_balance', 8, 4)->default(0);
			$table->text('description')->nullable();
			$table->enum('type', array('USD', 'RMB'))->default('USD');
			$table->integer('portfolio_id')->unsigned();
			
			$table->timestamps();
			
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
		Schema::table('account', function(Blueprint $table)
		{
			//
		});
	}

}
