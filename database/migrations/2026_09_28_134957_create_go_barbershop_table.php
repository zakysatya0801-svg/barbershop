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
        Schema::create('go_barbershops', function (Blueprint $table) {
            $table->id('go_barbershop_id');
              $table->foreignId('owner_id')
            ->constrained('owners', 'id')
            ->onDelete('cascade');
               $table->foreignId('location_id')
            ->nullable()
            ->after('owner_id')
            ->constrained('locations', 'location_id')
            ->onDelete('set null');
            $table->string('barbershop_name');
            $table->text('description')->nullable();
            $table->fullText('photo')->nullable();
            $table->time('open_time');
            $table->time('close_time');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('go_barbershop');
    }
};
