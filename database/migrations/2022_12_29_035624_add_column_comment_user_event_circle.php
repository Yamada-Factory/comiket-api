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
            $table->integer('price')->nullable()->after('favorite_circle_id')->comment('予算');
            $table->text('comment')->nullable()->after('favorite_circle_id')->comment('コメント');
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
            $table->dropColumn('price');
            $table->dropColumn('comment');
        });
    }
};
