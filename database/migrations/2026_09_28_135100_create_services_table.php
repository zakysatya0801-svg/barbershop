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

            $table->foreignId('go_barbershop_id')
                ->constrained('go_barbershops', 'go_barbershop_id')
                ->cascadeOnDelete();

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
