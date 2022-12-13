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
        Schema::create('event', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->comment('イベント名');
            $table->string('location_facility')->nullable()->comment('イベント会場_施設名');
            $table->text('location_address')->nullable()->comment('イベント会場_住所');
            $table->text('location_googlemap')->nullable()->comment('イベント会場_マップ');
            $table->string('location_latitude')->nullable()->comment('イベント会場_緯度');
            $table->string('location_longitude')->nullable()->comment('イベント会場_軽度');
            $table->dateTime('from_at')->nullable();
            $table->dateTime('to_at')->nullable();
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
        Schema::dropIfExists('event');
    }
};
