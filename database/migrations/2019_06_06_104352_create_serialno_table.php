<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerialnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serialno', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('channel')->comment('通道号');
            $table->string('serialno')->comment('设备序列号');
            $table->string('ipaddr')->comment('设备ip');
            $table->string('deviceName')->comment('设备名称');
            $table->smallInteger('serialChannel')->comment('串口通道号');
            $table->longText('data')->comment('串口数据， base64编码');
            $table->integer('dataLen')->comment('数据长度');
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
        Schema::dropIfExists('serialno');
    }
}
