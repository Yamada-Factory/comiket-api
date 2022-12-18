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
        Schema::create('user_favorite_event_circle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->unsignedBigInteger('favotite_circle_id')->comment('お気に入りサークル_ID');
            $table->unsignedBigInteger('priority')->default(0)->comment('優先度');
            $table->boolean('e-commerce_flag')->default(false)->comment('通販フラグ');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('favotite_circle_id')->references('id')->on('user_favorite_circle')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_favorite_event_circle');
    }
};
