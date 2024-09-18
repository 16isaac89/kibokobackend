<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDriverWalletsTable extends Migration
{
    public function up()
    {
        Schema::table('driver_wallets', function (Blueprint $table) {
            $table->unsignedBigInteger('paymentmethod_id')->nullable();
            $table->foreign('paymentmethod_id', 'paymentmethod_fk_4454683')->references('id')->on('payment_methods');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id', 'driver_fk_4454685')->references('id')->on('drivers');
        });
    }
}
