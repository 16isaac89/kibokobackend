<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRideCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ride_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('passengers')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
