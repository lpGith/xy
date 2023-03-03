<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('分类名称');
            $table->unsignedBigInteger('article_cate_id')->default(0)->comment('文章分类id');
            $table->unsignedTinyInteger('nav_type')->default(1)->comment('导航类型');
            $table->string('url', 100)->comment('url');
            $table->string('sequence')->default(10)->comment('显示顺序');
            $table->unsignedTinyInteger('state')->default(0)->comment('状态,0:显示 1:隐藏');
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
        Schema::dropIfExists('navigations');
    }
}
