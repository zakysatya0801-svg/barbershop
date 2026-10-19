<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');

            $table->foreignId('customer_id')
                ->constrained('customers', 'customer_id')
                ->cascadeOnDelete();

            $table->foreignId('go_barbershop_id')
                ->constrained('go_barbershops', 'go_barbershop_id')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('services', 'service_id')
                ->cascadeOnDelete();

            $table->foreignId('barber_id')
                ->constrained('barbers', 'barber_id')
                ->cascadeOnDelete();

            $table->date('booking_date');
            $table->string('time_slot');
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
