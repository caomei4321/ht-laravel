<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('plateid')->comment('车牌ID');
            $table->string('license')->comment('车牌号');
            $table->smallInteger('colorType')->comment('车辆颜色');
            $table->smallInteger('type')->comment('车牌类型');
            $table->string('colorValue')->comment('颜色值 预留');
            $table->string('carColor')->comment('车身颜色');
            $table->integer('enable')->default('1')->comment('当前名单是否有效， 0无效 1有效');
            $table->integer('need_alarm')->default('0')->comment('当前名单是否为黑名单， 0否 1黑名单');
            $table->dateTime('enable_time')->comment('当前名单生效时间');
            $table->dateTime('overdue_time')->comment('当前名单过期时间');
            $table->smallInteger('operate_type')->default('0')->comment('操作类型 0增加  1删除');
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
        Schema::dropIfExists('cars');
    }
}
