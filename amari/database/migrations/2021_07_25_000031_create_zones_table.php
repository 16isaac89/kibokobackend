<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesTable extends Migration
{
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zone');
            $table->integer('from');
            $table->integer('to');
            $table->integer('distance');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
