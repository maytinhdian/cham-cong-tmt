<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add explicit switch state and minute thresholds for per-shift overtime rules.
     */
    public function up(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            if (! Schema::hasColumn('shifts', 'overtime_before_shift_min_minutes')) {
                $table->unsignedInteger('overtime_before_shift_min_minutes')->default(0)->after('overtime_before_shift_enabled');
            }

            if (! Schema::hasColumn('shifts', 'overtime_after_shift_enabled')) {
                $table->boolean('overtime_after_shift_enabled')->default(true)->after('overtime_before_shift_min_minutes');
            }
        });
    }

    /**
     * Remove the added switch state and before-shift threshold fields.
     */
    public function down(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            foreach (['overtime_after_shift_enabled', 'overtime_before_shift_min_minutes'] as $column) {
                if (Schema::hasColumn('shifts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
