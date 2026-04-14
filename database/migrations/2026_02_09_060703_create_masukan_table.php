<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('masukan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email'); // ✅ ditambahkan
            $table->text('pesan');
            $table->tinyInteger('rating'); // 1-5 bintang
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masukan');
    }
};