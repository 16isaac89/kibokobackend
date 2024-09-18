<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingServicePivotTable extends Migration
{
    public function up()
    {
        Schema::create('booking_service', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id', 'booking_id_fk_4454926')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id', 'service_id_fk_4454926')->references('id')->on('services')->onDelete('cascade');
        });
    }
}
