<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('second_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link')->default('')->comment('链接地址');
            $table->string('phone', '11')->default('')->comment('手机号');
            $table->string('sum', '10')->default('')->comment('房屋总金额');
            $table->string('community', '100')->default('')->comment('小区名称');
            $table->string('area')->default('')->comment('面积');
            $table->string('name', '20')->default('')->comment('姓名');
            $table->string('region', '20')->default('')->comment('区域 -- 东港区.岚山区.市区.开发区等');
            $table->integer('post_date')->default(0)->comment('发布时间');
            $table->string('from', '50')->default('')->comment('来源的平台 ...58');
            $table->tinyInteger('type')->default(0)->comment('1 => 个人');
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
        Schema::dropIfExists('second_houses');
    }
}
