<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Relax legacy columns so the new device module can write normalized fields.
     */
    public function up(): void
    {
        if (Schema::hasTable('attendance_devices') && Schema::hasColumn('attendance_devices', 'type')) {
            DB::statement('ALTER TABLE attendance_devices MODIFY `type` VARCHAR(255) NULL DEFAULT NULL');
        }
    }

    /**
     * Keep legacy column normalization on rollback to avoid breaking existing data.
     */
    public function down(): void
    {
        // Intentionally left as a no-op for safety with legacy device data.
    }
};
