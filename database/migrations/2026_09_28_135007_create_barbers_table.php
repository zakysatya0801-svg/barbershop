<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barbers', function (Blueprint $table) {
            $table->id('barber_id');

            // Relasi ke tabel go_barbershops
            $table->unsignedBigInteger('shop_id');

            $table->foreign('shop_id')
                ->references('go_barbershop_id')
                ->on('go_barbershops')
                ->onDelete('cascade');

            $table->string('barber_name');
            $table->string('specialty');
            $table->longText('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barbers');
    }
};