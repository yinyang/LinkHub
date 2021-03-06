<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->tinyInteger('type')->default(0);    // 0链接，1公众号，2书籍，3生活
            $table->integer('topic_id')->default(0);    // 所属主题，一个链接有且只属于一个主题。

            $table->string('name');                     // 标题
            $table->text('url');                        // 地址
            $table->text('mark')->nullable();           // 简介
            $table->string('image')->nullable();        // 图标、二维码、书面、图片
            $table->string('tags')->nullable();         // 标签（逗号分隔）

            $table->integer('favo')->default(0);        // 收藏数
            $table->integer('greet')->default(0);       // 点赞数
            $table->integer('disgreet')->default(0);    // 反对数
            $table->integer('click_count')->default(0);    // 点击数

            $table->tinyInteger('state')->default(0);   // 状态：0未审核，1审核，2拒绝
            $table->string('state_info')->nullable();   // 拒绝理由

            $table->integer('user_id');           // 首次分享的用户ID
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
}
