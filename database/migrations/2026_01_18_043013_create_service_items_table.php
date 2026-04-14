<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_items', function (Blueprint $table) {
    $table->id();
    $table->string('item_name'); // nama item: oli, ban, aki
    $table->string('category')->nullable(); // oli, ban, aki
    $table->integer('price');
    $table->integer('stock')->default(0);
        $table->string('image')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('service_items');
    }
};

