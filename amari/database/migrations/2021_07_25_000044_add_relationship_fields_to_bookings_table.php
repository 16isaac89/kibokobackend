<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4367555')->references('id')->on('customers');
            $table->unsignedBigInteger('car_type_id')->nullable();
            $table->foreign('car_type_id', 'car_type_fk_4372529')->references('id')->on('ride_categories');
            $table->unsignedBigInteger('paymentmethod_id')->nullable();
            $table->foreign('paymentmethod_id', 'paymentmethod_fk_4361065')->references('id')->on('payment_methods');
        });
    }
}
