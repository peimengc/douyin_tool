<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('aweme_user_id')->comment('抖音账号id');
            $table->unsignedBigInteger('target_fans')->comment('目标粉丝');
            $table->unsignedInteger('init_follow')->default(0)->comment('初始关注');
            $table->unsignedInteger('init_fans')->default(0)->comment('初始粉丝');
            $table->unsignedInteger('over_follow')->default(0)->comment('结束关注');
            $table->unsignedInteger('over_fans')->default(0)->comment('结束粉丝');
            $table->unsignedBigInteger('add_fans')->default(0)->comment('增粉数');
            $table->unsignedTinyInteger('status')->index()->default(1)->comment('状态：1正常,2完成');
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
        Schema::dropIfExists('follow_tasks');
    }
}
