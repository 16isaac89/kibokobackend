<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('dealer_id');
            $table->integer('subscription_id');
            $table->text('transaction_id');
            $table->string('status');
            $table->date('from_date');
            $table->date('to_date');
            $table->date('paid_on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dealer_subscriptions');
    }
}
