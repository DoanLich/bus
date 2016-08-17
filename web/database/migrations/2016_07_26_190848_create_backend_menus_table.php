<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('permission_id')->unsigned()->nullable();
            $table->string('index')->notnull()->index();
            $table->string('name')->notnull();
            $table->string('icon');
            $table->integer('level');
            $table->integer('order');
            $table->string('route');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('backend_menus')->onDelete('set null');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('backend_menus');
    }
}
