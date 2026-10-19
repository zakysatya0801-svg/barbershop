<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('favorite_id');

            $table->foreignId('customer_id')
                ->constrained('customers', 'customer_id')
                ->cascadeOnDelete();

            $table->foreignId('go_barbershop_id')
                ->constrained('go_barbershops', 'go_barbershop_id')
                ->cascadeOnDelete();

            $table->unique(['customer_id', 'go_barbershop_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
