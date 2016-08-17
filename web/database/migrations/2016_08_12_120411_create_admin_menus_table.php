<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function(Blueprint $table) {
            $table->increments('id');
            $table->string('index')->unique();
            $table->unsignedInteger('permission_id')->nullable();
            $table->string('name');
            $table->string('icon');
            $table->integer('level');
            $table->integer('order');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('route');
            $table->timestamps();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('admin_menus')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_menus');
    }
}
