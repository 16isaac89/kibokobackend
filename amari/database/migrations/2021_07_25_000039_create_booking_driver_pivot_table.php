<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDriverPivotTable extends Migration
{
    public function up()
    {
        Schema::create('booking_driver', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id', 'booking_id_fk_4372527')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id', 'driver_id_fk_4372527')->references('id')->on('drivers')->onDelete('cascade');
        });
    }
}
