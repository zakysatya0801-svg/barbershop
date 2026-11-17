<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Tambahkan role jika belum tersedia.
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')
                    ->nullable();
            }

            // Tambahkan status jika belum tersedia.
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')
                    ->default('active');
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }

        });
    }
};
