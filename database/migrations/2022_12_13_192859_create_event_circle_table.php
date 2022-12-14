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
        Schema::create('event_circle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id')->comment('サークルID');
            $table->unsignedBigInteger('event_id')->comment('イベントID');
            $table->string('hall')->nullable()->commnet('');
            $table->string('day')->nullable()->commnet('');
            $table->string('block')->nullable()->commnet('');
            $table->string('space')->nullable()->commnet('');
            $table->string('genre')->nullable()->commnet('');
            $table->text('description')->nullable()->commnet('');
            $table->json('images')->nullable();
            $table->json('other')->nullable();
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circle')->cascadeOnDelete();
            $table->foreign('event_id')->references('id')->on('event')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_circle');
    }
};
