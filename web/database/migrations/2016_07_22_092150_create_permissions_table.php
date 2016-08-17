<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('index')->notnull()->index()->unique();
            $table->string('name')->notnull()->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->string('group', 32)->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('permissions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
    }
}
