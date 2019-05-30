<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHtDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ht_datas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('device_id')->unsigned()->index('ht_datas_device_id_foreign');
			$table->float('temperature');
			$table->float('humidity');
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
		Schema::drop('ht_datas');
	}

}
