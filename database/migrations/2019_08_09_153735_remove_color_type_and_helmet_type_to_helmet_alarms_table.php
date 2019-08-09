<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColorTypeAndHelmetTypeToHelmetAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('helmet_alarms', function (Blueprint $table) {
            $table->dropColumn('color_type');
            $table->dropColumn('helmet_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('helmet_alarms', function (Blueprint $table) {
            $table->unsignedInteger('color_type');
            $table->unsignedInteger('helmet_type');
        });
    }
}
