<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('favorite_id');

            // Relasi ke tabel customers
            $table->foreignId('customer_id')
                ->constrained('customers', 'customer_id')
                ->onDelete('cascade');

            // Relasi ke tabel go_barbershops
            $table->foreignId('shop_id')
                ->constrained('go_barbershops', 'go_barbershop_id')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};