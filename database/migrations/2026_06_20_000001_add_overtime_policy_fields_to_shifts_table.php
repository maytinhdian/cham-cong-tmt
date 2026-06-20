<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add per-shift overtime policy settings.
     */
    public function up(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            if (! Schema::hasColumn('shifts', 'overtime_before_shift_enabled')) {
                $table->boolean('overtime_before_shift_enabled')->default(false)->after('requires_clock_out');
            }

            if (! Schema::hasColumn('shifts', 'overtime_after_shift_min_minutes')) {
                $table->unsignedInteger('overtime_after_shift_min_minutes')->default(0)->after('overtime_before_shift_enabled');
            }
        });
    }

    /**
     * Remove per-shift overtime policy settings.
     */
    public function down(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            foreach (['overtime_before_shift_enabled', 'overtime_after_shift_min_minutes'] as $column) {
                if (Schema::hasColumn('shifts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
