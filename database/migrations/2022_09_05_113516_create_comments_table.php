<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('用户id');
            $table->unsignedBigInteger('article_id')->comment('文章id');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父级id');
            $table->string('name', 50)->nullable()->default(null)->comment('评论用户');
            $table->string('email')->nullable()->default(null)->comment('用户email');
            $table->string('website')->nullable()->default(null)->comment('网站');
            $table->string('avatar')->nullable()->default(null)->comment('头像');
            $table->string('city')->nullable()->default(null)->comment('所在城市');
            $table->string('ip')->nullable()->default(null)->comment('ip');
            $table->string('target_name')->nullable()->default(null)->comment('被评论用户');
            $table->text('content')->nullable()->default(null)->comment('评论内容');
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
        Schema::dropIfExists('comments');
    }
}
