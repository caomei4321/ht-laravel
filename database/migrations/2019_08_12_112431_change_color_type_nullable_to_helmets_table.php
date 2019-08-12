<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColorTypeNullableToHelmetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('helmets', function (Blueprint $table) {
            $table->unsignedInteger('color_type')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('helmets', function (Blueprint $table) {
            $table->unsignedInteger('color_type')->nullable(false)->change();
            });
    }
}
