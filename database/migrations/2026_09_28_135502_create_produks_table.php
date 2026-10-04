<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('produk_id');

            // Relasi ke tabel go_barbershops
            $table->foreignId('shop_id')
                ->constrained('go_barbershops', 'go_barbershop_id')
                ->onDelete('cascade');

            $table->string('name_product');
            $table->decimal('price', 15, 2);
            $table->text('description')->nullable();
            $table->longText('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};