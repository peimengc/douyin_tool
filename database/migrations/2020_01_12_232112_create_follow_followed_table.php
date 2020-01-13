<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowFollowedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_followed', function (Blueprint $table) {
            $table->unsignedBigInteger('follow_id');
            $table->foreign('follow_id')
                ->references('id')
                ->on('aweme_users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('followed_id');
            $table->foreign('followed_id')
                ->references('id')
                ->on('aweme_users')
                ->onDelete('cascade');
            $table->unique(['follow_id','followed_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_followed');
    }
}
