<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_message', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('plateid')->comment('车牌id');
            $table->string('serialno')->comment('设备序列号');
            $table->smallInteger('channel')->comment('默认通道口');
            $table->string('deviceName')->comment('设备名称');
            $table->string('ipaddr')->comment('设备IP地址');
            $table->string('license')->comment('车牌号');
            $table->smallInteger('colorValue')->comment('颜色值');
            $table->smallInteger('colorType')->comment('车牌颜色');
            $table->smallInteger('type')->comment('车牌类型');
            $table->smallInteger('confidence')->comment('识别结果可行度1-100');
            $table->smallInteger('bright')->comment('预留亮度');
            $table->smallInteger('direction')->comment('行进方向');
            $table->smallInteger('bottom')->comment('方向下');
            $table->smallInteger('left')->comment('方向左');
            $table->smallInteger('right')->comment('方向右');
            $table->smallInteger('top')->comment('方向上');
            $table->smallInteger('timeUsed')->comment('识别所用时间');
            $table->smallInteger('carBright')->comment('车身亮度');
            $table->smallInteger('carColor')->comment('车身颜色');
            $table->bigInteger('sec')->comment('帧秒');
            $table->bigInteger('usec')->comment('毫秒');
            $table->string('imagePath')->comment('图片路径');
            $table->string('imageFile')->comment('base64大图路径');
            $table->string('imageFragmentFile')->comment('base64小图路径');
            $table->smallInteger('triggerType')->comment('结果的触发类型');
            $table->smallInteger('isoffline')->comment('是否为脱机记录');
            $table->string('gioouts')->comment('开闸信息');
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
        Schema::dropIfExists('push_message');
    }
}
