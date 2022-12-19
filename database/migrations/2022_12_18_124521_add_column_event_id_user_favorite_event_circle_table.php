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
        Schema::table('user_favorite_event_circle', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable()->after('favotite_circle_id')->comment('イベントID');

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
        Schema::table('user_favorite_event_circle', function (Blueprint $table) {
            $table->dropColumn('event_id');
        });
    }
};
