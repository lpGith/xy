<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->default(0)->comment('文章作者');
            $table->unsignedInteger('cate_id')->default(0)->comment('分类id');
            $table->string('title', 200)->default('')->comment('文章标题');
            $table->string('desc', 255)->default('')->comment('文章描述');
            $table->string('keyword', 255)->default('blog')->comment('文章关键字');
            $table->text('html_content')->comment('文章内容');
            $table->unsignedBigInteger('read_count')->default(0)->comment('文章浏览次数');
            $table->unsignedBigInteger('comment_count')->default(0)->comment('文章评论次数');
            $table->unsignedBigInteger('sort')->default(10)->comment('文章排序');
            $table->string('list_pic', 255)->default('')->comment('文章展示图片');
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
        Schema::dropIfExists('articles');
    }
}
