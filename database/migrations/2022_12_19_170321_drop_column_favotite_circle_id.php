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
            $table->dropForeign('user_favorite_event_circle_favotite_circle_id_foreign');
            $table->dropColumn('favotite_circle_id');
            $table->unsignedBigInteger('favorite_circle_id')->nullable()->after('user_id')->comment('お気に入りサークル_ID');

            $table->foreign('favorite_circle_id')->references('id')->on('user_favorite_circle')->cascadeOnDelete();
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
            $table->unsignedBigInteger('favotite_circle_id')->comment('お気に入りサークル_ID');
            $table->dropForeign('user_favorite_event_circle_favorite_circle_id_foreign');
            $table->dropColumn('favorite_circle_id');

            $table->foreign('favotite_circle_id')->references('id')->on('user_favorite_circle')->cascadeOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }
};
