<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageBoardTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('image_board', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->timestamps();
				
			$table->integer('user_id')->unsigned();
			$table->integer('image_id')->unsigned();
			$table->integer('board_id')->unsigned();
				
			$table->foreign('user_id')->references('id')
			->on('users')->onUpdate('cascade')
			->onDelete('cascade');
			$table->foreign('image_id')->references('id')
			->on('images')->onUpdate('cascade')
			->onDelete('cascade');
			$table->foreign('board_id')->references('id')
			->on('boards')->onUpdate('cascade')
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
		//TODO
		Schema::drop('image_board');
	}

	
}
