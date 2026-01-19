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
        Schema::table('rentals', function (Blueprint $table) {
            $table->bigInteger('dp_amount')->nullable();
            $table->string('payment_method')->nullable(); // qris
            $table->string('payment_status')->default('unpaid'); // unpaid | paid_dp | paid_full
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            //
        });
    }
};
