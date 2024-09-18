<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToZoneRidesTable extends Migration
{
    public function up()
    {
        Schema::table('zone_rides', function (Blueprint $table) {
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id', 'zone_fk_4372460')->references('id')->on('zones');
        });
    }
}
