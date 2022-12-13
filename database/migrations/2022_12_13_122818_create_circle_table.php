<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('circle_ms_id')->nullable()->comment('circle.ms のID');
            $table->string('name')->nullable()->comment('サークル名');
            $table->string('author')->nullable()->comment('作家名');
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
        Schema::dropIfExists('circle');
    }
};
