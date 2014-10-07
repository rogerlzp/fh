<?php

use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

    public function up()
    {
        Schema::create('profiles', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            
            
            $table->string('company')->nullable()->default(NULL);
            $table->string('company_page')->nullable()->default(NULL);
            $table->string('department')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->string('email2')->nullable()->default(NULL);
            $table->string('mobile')->nullable()->default(NULL);
            $table->string('mobile2')->nullable()->default(NULL);
            $table->string('phone')->nullable()->default(NULL);
            $table->string('phone2')->nullable()->default(NULL);
            $table->string('fax')->nullable()->default(NULL);
            $table->string('address')->nullable()->default(NULL);
            $table->string('im')->nullable()->default(NULL);
            $table->string('social')->nullable()->default(NULL);
            $table->boolean('newjob')->nullable()->default(false);
            
            $table->string('name')->nullable()->default(NULL);
            $table->string('first_name')->nullable()->default(NULL);
            $table->string('last_name')->nullable()->default(NULL);
            $table->string('reserved1')->nullable()->default(NULL);
            $table->string('reserved2')->nullable()->default(NULL);
            $table->string('reserved3')->nullable()->default(NULL);
            $table->string('reserved4')->nullable()->default(NULL);

            
			
            $table->string('access_token')->nullable()->default(NULL);
            $table->string('access_token_secret')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('profiles', function($table)
        {
            $table->dropForeign('profiles_user_id_foreign');
        });

        Schema::drop('profiles');
    }

}
