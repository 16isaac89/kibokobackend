<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingRidePivotTable extends Migration
{
    public function up()
    {
        Schema::create('booking_ride', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id', 'booking_id_fk_4372528')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('ride_id');
            $table->foreign('ride_id', 'ride_id_fk_4372528')->references('id')->on('rides')->onDelete('cascade');
        });
    }
}
