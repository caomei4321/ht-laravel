<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelmetAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helmet_alarms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_id');
            $table->timestamp('alarm_time');
            $table->string('alarm_pic_url');
            $table->unsignedInteger('color_type');
            $table->unsignedInteger('helmet_type');
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
        Schema::dropIfExists('helmet_alarms');
    }
}
