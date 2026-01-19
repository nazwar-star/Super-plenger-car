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
        Schema::create('rentals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('car_id')->constrained()->onDelete('cascade');
        $table->string('user_name'); // Nama penyewa
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('total_days');
        $table->integer('total_price');
        $table->integer('dp');
        $table->enum('status', ['ongoing','completed'])->default('ongoing');
        $table->timestamps();
    });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
