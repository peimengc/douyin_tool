<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwemeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aweme_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('uid')->unique();
            $table->string('unique_id')->nullable()->unique();
            $table->string('short_id')->nullable()->unique();
            $table->string('nick');
            $table->string('avatar_uri')->nullable();
            $table->unsignedBigInteger('fans')->default(0);
            $table->unsignedBigInteger('follow')->default(0);
            $table->unsignedInteger('tool_follow')->default(0);
            $table->unsignedInteger('tool_fans')->default(0);
            $table->unsignedInteger('init_follow')->default(0);
            $table->unsignedInteger('init_fans')->default(0);
            $table->unsignedInteger('today_follow')->default(0);
            $table->string('cookie')->nullable();
            $table->timestamp('update_time')->index()->nullable()->comment('更新时间，通过抖音api');
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
        Schema::dropIfExists('aweme_users');
    }
}
