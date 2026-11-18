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
        $missingColumns = [];

        if (! Schema::hasColumn('users', 'role')) {
            $missingColumns[] = 'role';
        }

        if (! Schema::hasColumn('users', 'status')) {
            $missingColumns[] = 'status';
        }

        if ($missingColumns === []) {
            return;
        }

        Schema::table('users', function (Blueprint $table) use ($missingColumns): void {
            if (in_array('role', $missingColumns, true)) {
                $table->string('role')->nullable();
            }

            if (in_array('status', $missingColumns, true)) {
                $table->string('status')->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep account columns because they may have existed before this repair migration.
    }
};
