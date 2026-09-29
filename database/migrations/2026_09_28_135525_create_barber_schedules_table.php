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
        Schema::create('barber_schedules', function (Blueprint $table) {
    $table->id('barber_schedule_id');

    $table->foreignId('barber_id')
        ->constrained('barbers', 'barber_id')
        ->onDelete('cascade');

    $table->string('day');
    $table->time('start_time');
    $table->time('end_time');
    $table->boolean('status')->default(true);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barber_schedules');
    }
};
