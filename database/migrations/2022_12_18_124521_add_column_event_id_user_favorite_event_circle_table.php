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
        Schema::disableForeignKeyConstraints();
        Schema::table('user_favorite_event_circle', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable()->after('favotite_circle_id')->comment('イベントID');

            $table->foreign('event_id')->references('id')->on('event')->cascadeOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('user_favorite_event_circle', function (Blueprint $table) {
            $table->dropForeign('user_favorite_event_circle_event_id_foreign');
            $table->dropColumn('event_id');
        });
        Schema::enableForeignKeyConstraints();
    }
};
