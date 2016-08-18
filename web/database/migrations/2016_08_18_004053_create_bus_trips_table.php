<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_trips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('start_location')->unsigned()->nullable();
            $table->integer('end_location')->unsigned()->nullable();
            $table->string('start_point')->nullable();
            $table->string('end_point')->nullable();
            $table->string('start_time', 16)->nullable();
            $table->string('end_time', 16)->nullable();
            $table->string('seat_type')->nullable();
            $table->integer('seat_count')->nullable();
            $table->double('price')->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('start_location')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('end_location')->references('id')->on('locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bus_trips');
    }
}
