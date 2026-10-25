<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commission_schemes', function (Blueprint $table) {
            $table->id('commission_scheme_id');
            $table->foreignId('go_barbershop_id')
                ->constrained('go_barbershops', 'go_barbershop_id')
                ->cascadeOnDelete();
            $table->decimal('commission_rate', 5, 2);
            $table->timestamp('valid_from');
            $table->timestamp('valid_to')->nullable();
            $table->unique(
                ['go_barbershop_id', 'valid_from'],
                'commission_schemes_shop_valid_from_unique'
            );
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_schemes');
    }
};
