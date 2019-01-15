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
      $table->string('qiu_url')->unique()->comment('糗百图片地址');
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
