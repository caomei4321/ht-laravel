<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->string('job_number')->nullable();
			$table->string('image')->nullable();
			$table->softDeletes();
			$table->string('image_name')->nullable();
			$table->string('phone')->nullable();
			$table->string('password')->nullable();
			$table->integer('department_id')->unsigned()->nullable();
			$table->integer('company_id')->unsigned()->nullable();
            $table->string('open_id')->nullable();
            $table->string('weixin_session_key')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
