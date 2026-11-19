<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasLegacyColumn = Schema::hasColumn('barbers', 'shop_id');
        $hasCanonicalColumn = Schema::hasColumn(
            'barbers',
            'go_barbershop_id'
        );

        if ($hasCanonicalColumn && ! $hasLegacyColumn) {
            return;
        }

        if ($hasLegacyColumn && $hasCanonicalColumn) {
            throw new RuntimeException(
                'The barbers table contains both shop_id and go_barbershop_id.'
            );
        }

        if (! $hasLegacyColumn) {
            throw new RuntimeException(
                'The barbers table is missing the shop_id column.'
            );
        }

        $isSqlite = DB::connection()->getDriverName() === 'sqlite';

        if (! $isSqlite) {
            Schema::table('barbers', function (Blueprint $table): void {
                $table->dropForeign(['shop_id']);
            });
        }

        Schema::table('barbers', function (Blueprint $table): void {
            $table->renameColumn('shop_id', 'go_barbershop_id');
        });

        if (! $isSqlite) {
            Schema::table('barbers', function (Blueprint $table): void {
                $table->foreign('go_barbershop_id')
                    ->references('go_barbershop_id')
                    ->on('go_barbershops')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        throw new LogicException(
            'This compatibility migration cannot be rolled back safely.'
        );
    }
};
