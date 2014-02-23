<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;

class FlynsarmyOrchestracmsCreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orchestra_cms_pages', function ($table) {
            $table->increments('id');
            $table->string('theme');
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('orchestra_cms_templates');
            $table->integer('user_id')->references('id')->on('users');
            $table->boolean('is_enabled')->default(true);
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('content_dir');
            $table->string('meta_description');
            $table->string('meta_keywords');

            $table->timestamps();

            $table->index('theme');
            $table->index('slug');
            $table->index('is_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orchestra_cms_pages');
    }
}
