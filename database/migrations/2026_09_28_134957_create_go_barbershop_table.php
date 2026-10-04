<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('go_barbershops', function (Blueprint $table) {
            $table->id('go_barbershop_id');

            // Relasi ke tabel owners
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')
                ->references('owner_id')
                ->on('owners')
                ->onDelete('cascade');

            // Relasi ke tabel locations (nullable)
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')
                ->references('location_id')
                ->on('locations')
                ->nullOnDelete();

            $table->string('barbershop_name');
            $table->text('description')->nullable();
            $table->text('photo')->nullable();
            $table->time('open_time');
            $table->time('close_time');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('go_barbershops');
    }
};