<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('car_orders', function (Blueprint $table) {
            $table->id();

            // RELASI
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();

            // JENIS TRANSAKSI
            $table->enum('type', ['rental', 'buy']);

            // RENTAL DETAIL (hanya jika rental)
            $table->date('start_date')->nullable();
            $table->integer('duration_days')->nullable();

            // DELIVERY
            $table->enum('delivery_method', ['diantar', 'ambil_sendiri']);

            // PEMBAYARAN
            $table->enum('payment_method', ['transfer', 'cash']);
            $table->string('bank_name')->nullable();

            // FILE UPLOAD
            $table->string('ktp_photo')->nullable();       // wajib jika rental
            $table->string('payment_proof')->nullable();  // wajib jika transfer

            // HARGA & STATUS
            $table->bigInteger('price');
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');

            // APPROVAL ADMIN
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_orders');
    }
};
