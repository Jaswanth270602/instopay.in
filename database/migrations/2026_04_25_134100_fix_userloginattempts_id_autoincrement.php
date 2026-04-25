<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('userloginattempts')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver !== 'mysql') {
            return;
        }

        // Ensure id is primary first, then apply AUTO_INCREMENT.
        $primary = DB::select("SHOW KEYS FROM `userloginattempts` WHERE Key_name = 'PRIMARY'");
        if (empty($primary)) {
            DB::statement('ALTER TABLE `userloginattempts` ADD PRIMARY KEY (`id`)');
        }

        DB::statement('ALTER TABLE `userloginattempts` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally no-op. Reverting this can break production data.
    }
};

