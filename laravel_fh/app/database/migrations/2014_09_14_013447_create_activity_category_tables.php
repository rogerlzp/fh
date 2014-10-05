<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityCategoryTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activity_category', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->integer('activity_id')->unsigned();
			$table->timestamps();
			
			$table->foreign('category_id')
			->references('id')->on('categories')
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

		Schema::table('activity_category', function($table)
		{
			$table->dropForeign('activity_category_category_id_foreign');
			$table->dropForeign('activity_category_activity_id_foreign');
		});
		Schema::drop('activity_category');
	}

}
