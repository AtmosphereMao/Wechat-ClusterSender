<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebpageCssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webpage_css', function (Blueprint $table) {
            $table->increments('id');
            $table->string('css_name');
            $table->string('css_filename');
            $table->string('js_filename');
            $table->string('snapshot_filename');
            $table->string('html_filename');
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
        Schema::drop('webpage_css');
    }
}
