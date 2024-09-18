<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('triptype')->nullable();
            $table->string('type')->nullable();
            $table->string('fullname')->nullable();
            $table->integer('passengers')->nullable();
            $table->integer('days')->nullable();
            $table->string('from');
            $table->string('to');
            $table->string('stops')->nullable();
            $table->datetime('date')->nullable();
            $table->string('recommender')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
