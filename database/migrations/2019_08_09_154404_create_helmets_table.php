<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelmetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helmets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id');
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
        Schema::dropIfExists('helmets');
    }
}
