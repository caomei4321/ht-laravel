<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_records', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->text('job_number', 65535);
			$table->softDeletes();
			$table->timestamps();
			$table->string('license')->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_records');
	}

}
