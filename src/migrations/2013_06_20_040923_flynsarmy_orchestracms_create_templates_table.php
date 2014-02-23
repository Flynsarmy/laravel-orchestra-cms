<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;

class FlynsarmyOrchestracmsCreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orchestra_cms_templates', function ($table) {
            $table->increments('id');
            $table->string('theme');
            $table->integer('user_id')->references('id')->on('users');
            $table->string('title');
            $table->text('description');
            $table->string('content_dir');

            $table->timestamps();

            $table->index('theme');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orchestra_cms_templates');
    }
}
