
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barbershop_qr_tokens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('barbershop_id')
                ->constrained('barbershops')
                ->restrictOnDelete();

            $table->char('token_hash', 64)->unique();
            $table->string('status', 20)->default('active');

            $table->timestamp('issued_at');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('revoked_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'revoked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barbershop_qr_tokens');
    }
};
