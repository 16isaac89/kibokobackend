<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dealer_permission_dealer_role', function (Blueprint $table) {
            $table->Integer('dealer_permission_id');
            $table->foreign('dealer_permission_id', 'dealer_permission_id_fk_4454219')->references('id')->on('dealer_permissions');
            $table->Integer('dealer_role_id');
            $table->foreign('dealer_role_id', 'dealer_role_id_fk_4454219')->references('id')->on('dealer_roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealer_permission_dealer_role');
    }
};
