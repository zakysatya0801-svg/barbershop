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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');

            $table->foreignId('costumer_id')
                ->constrained('costumers', 'costumer_id')
                ->onDelete('cascade');

            $table->foreignId('shop_id')
                ->constrained('shops', 'shop_id')
                ->onDelete('cascade');

            $table->foreignId('booking_id')
                ->constrained('bookings', 'booking_id')
                ->onDelete('cascade');

            $table->tinyInteger('rating');

            $table->text('comment')->nullable();

            $table->timestamps();

            // Satu booking hanya boleh memiliki satu review
            $table->unique('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};