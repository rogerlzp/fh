<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTagTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activity_tag', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id')->unsigned();
			$table->integer('tag_id')->unsigned();
			$table->integer('activity_id')->unsigned();
			$table->timestamps();
			
			$table->foreign('tag_id')
			->references('id')->on('tags')
			->onUpdate('cascade')
			->onDelete('cascade');
			
			$table->foreign('activity_id')
			->references('id')->on('activity')
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

		Schema::table('activity_tag', function($table)
		{
			$table->dropForeign('activity_tag_tag_id_foreign');
			$table->dropForeign('activity_tag_activity_id_foreign');
		});
		
		Schema::drop('activity_tag');
	}

}
