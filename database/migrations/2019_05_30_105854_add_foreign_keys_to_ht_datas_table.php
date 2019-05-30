<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHtDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ht_datas', function(Blueprint $table)
		{
			$table->foreign('device_id')->references('id')->on('devices')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ht_datas', function(Blueprint $table)
		{
			$table->dropForeign('ht_datas_device_id_foreign');
		});
	}

}
