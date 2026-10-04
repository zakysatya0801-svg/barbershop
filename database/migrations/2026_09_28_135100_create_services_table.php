<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');

            // Relasi ke tabel go_barbershops
            $table->unsignedBigInteger('shop_id');

            $table->foreign('shop_id')
                ->references('go_barbershop_id')
                ->on('go_barbershops')
                ->onDelete('cascade');

            $table->string('service_name');
            $table->longText('photo')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('duration');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};