
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('services', 'is_available')) {
            Schema::table('services', function (Blueprint $table) {
                $table->boolean('is_available')->default(true);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('services', 'is_available')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('is_available');
            });
        }
    }
};
