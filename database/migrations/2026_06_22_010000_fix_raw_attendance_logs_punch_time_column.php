<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Keep punch timestamps stable when raw-log processing status is updated.
     */
    public function up(): void
    {
        if (! Schema::hasTable('raw_attendance_logs')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE raw_attendance_logs MODIFY punch_time TIMESTAMP NOT NULL');
        }
    }

    /**
     * Restore the legacy MySQL timestamp behavior if this migration is rolled back.
     */
    public function down(): void
    {
        if (! Schema::hasTable('raw_attendance_logs')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE raw_attendance_logs MODIFY punch_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        }
    }
};
