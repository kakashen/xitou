<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQiuShiBaiKesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qiu_shi_bai_kes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('qiushi_tag_id', 100)->unique()->comment("糗事百科id");
            $table->text("content");
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
        Schema::dropIfExists('qiu_shi_bai_kes');
    }
}
