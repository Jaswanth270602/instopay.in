<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('loginlogs') || !Schema::hasColumn('loginlogs', 'id')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE `loginlogs` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');

        $primaryKey = DB::select("SHOW KEYS FROM `loginlogs` WHERE Key_name = 'PRIMARY'");
        if (empty($primaryKey)) {
            DB::statement('ALTER TABLE `loginlogs` ADD PRIMARY KEY (`id`)');
        }
    }

    public function down(): void
    {
        // Intentionally left empty: this is a one-way safety fix.
    }
};
