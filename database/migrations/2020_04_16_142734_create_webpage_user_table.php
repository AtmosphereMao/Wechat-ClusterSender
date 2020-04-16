<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebpageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webpage_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id');
            $table->string('NickName');
            $table->string('RemarkName');
            $table->string('Province');
            $table->string('City');
            $table->integer('user_id');
            $table->string('page_css');
            $table->text('page_content');
            $table->string('page_background');
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
        Schema::drop('webpage_user');
    }
}
