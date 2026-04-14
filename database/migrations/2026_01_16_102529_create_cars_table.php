<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('brand');
            $table->year('year');

            $table->bigInteger('rental_price')->nullable();
            $table->bigInteger('sale_price')->nullable();

            $table->integer('stock')->default(0);

            $table->enum('status', ['ready', 'rented', 'sold_out'])
                  ->default('ready');

            $table->text('description')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('model_3d')->nullable();
            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
