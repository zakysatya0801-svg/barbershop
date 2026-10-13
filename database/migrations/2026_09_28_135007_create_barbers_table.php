
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barbers', function (Blueprint $table) {
            $table->id('barber_id');

            $table->foreignId('go_barbershop_id')
                ->constrained('go_barbershops', 'go_barbershop_id')
                ->cascadeOnDelete();

            $table->string('barber_name');
            $table->string('specialty');
            $table->longText('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barbers');
    }
};
