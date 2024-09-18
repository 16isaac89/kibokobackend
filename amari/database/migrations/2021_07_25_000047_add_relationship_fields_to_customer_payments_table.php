<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCustomerPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('customer_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('received_by_id');
            $table->foreign('received_by_id', 'received_by_fk_4454537')->references('id')->on('users');
            $table->unsignedBigInteger('paymentmethod_id')->nullable();
            $table->foreign('paymentmethod_id', 'paymentmethod_fk_4454549')->references('id')->on('payment_methods');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id', 'booking_fk_4453566')->references('id')->on('bookings');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4453567')->references('id')->on('customers');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id', 'account_fk_4454550')->references('id')->on('accounts');
        });
    }
}
