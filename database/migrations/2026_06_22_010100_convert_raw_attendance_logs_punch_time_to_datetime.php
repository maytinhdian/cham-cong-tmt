<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Store device punch times as stable datetimes instead of auto-updating timestamps.
     */
    public function up(): void
    {
        if (! Schema::hasTable('raw_attendance_logs')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE raw_attendance_logs MODIFY punch_time DATETIME NOT NULL');
        }
    }

    /**
     * Convert the punch time back to a MySQL timestamp if rolled back.
     */
    public function down(): void
    {
        if (! Schema::hasTable('raw_attendance_logs')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE raw_attendance_logs MODIFY punch_time TIMESTAMP NOT NULL');
        }
    }
};
