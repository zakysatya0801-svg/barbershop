<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Hapus foreign key lama.
            $table->dropForeign('services_shop_id_foreign');

            // Ubah nama kolom.
            $table->renameColumn('shop_id', 'go_barbershop_id');

            // Buat foreign key baru.
            $table->foreign('go_barbershop_id')
                ->references('go_barbershop_id')
                ->on('go_barbershops')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign('services_go_barbershop_id_foreign');

            $table->renameColumn('go_barbershop_id', 'shop_id');

            $table->foreign('shop_id')
                ->references('go_barbershop_id')
                ->on('go_barbershops')
                ->cascadeOnDelete();
        });
    }
};
