<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgListsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('img_lists', function (Blueprint $table) {
      $table->increments('id');
      $table->string('url')->comment('微信图片地址');
      $table->string('media_id');
      $table->string('origin_url')->default('')->comment('原始图片地址');
      $table->string('name', 100)->default('')->comment('图片名称');
      $table->integer('type')->default(0)->comment('图片类型 0 -- 全部');
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
    Schema::dropIfExists('img_lists');
  }
}
