<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            ! Schema::hasColumn('services', 'shop_id')
            || Schema::hasColumn('services', 'go_barbershop_id')
        ) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign('services_shop_id_foreign');

            $table->renameColumn('shop_id', 'go_barbershop_id');

            $table->foreign('go_barbershop_id')
                ->references('go_barbershop_id')
                ->on('go_barbershops')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        if (
            ! Schema::hasColumn('services', 'go_barbershop_id')
            || Schema::hasColumn('services', 'shop_id')
        ) {
            return;
        }

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
