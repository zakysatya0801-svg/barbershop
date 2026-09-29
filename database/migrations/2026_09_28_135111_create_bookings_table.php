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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table-> $table->foreignId('customer_id')
            ->constrained('customers', 'customers_id')
            ->onDelete('cascade');
             $table->foreignId('shop_id')
             ->constrained('go_barber_shops', 'shop_id')
             ->onDelete('cascade');
              $table->foreignId('service')
              ->constrained('service', 'service_id')
              ->onDelete('cascade');
                $table->foreignId('barber_id')
                ->constrained('barbers', 'barber_id')
                ->onDelete('cascade');
               $table->date('booking_date');
               $table->string('time_slot');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};