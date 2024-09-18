<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('name')->nullable();
            $table->string('delivery')->nullable();
            $table->integer('tonnage')->nullable();
            $table->integer('capacity')->nullable();
            $table->string('manufacturer');
            $table->integer('fare');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
