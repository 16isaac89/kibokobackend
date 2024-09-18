<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('paymentmethod_id')->nullable();
            $table->foreign('paymentmethod_id', 'paymentmethod_fk_4454714')->references('id')->on('payment_methods');
        });
    }
}
