<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4454911')->references('id')->on('customers');
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id', 'booking_fk_4454914')->references('id')->on('bookings');
        });
    }
}
