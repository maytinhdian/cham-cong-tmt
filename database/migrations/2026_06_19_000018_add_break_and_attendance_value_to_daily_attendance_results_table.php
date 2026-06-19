<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add break and attendance value columns to the processed daily result table.
     */
    public function up(): void
    {
        if (! Schema::hasTable('daily_attendance_results')) {
            return;
        }

        Schema::table('daily_attendance_results', function (Blueprint $table) {
            if (! Schema::hasColumn('daily_attendance_results', 'break_minutes')) {
                $table->unsignedInteger('break_minutes')->default(0)->after('work_minutes');
            }

            if (! Schema::hasColumn('daily_attendance_results', 'attendance_value')) {
                $table->decimal('attendance_value', 4, 2)->default(0)->after('break_minutes');
            }
        });
    }

    /**
     * Remove break and attendance value columns when rolling back the detail layer.
     */
    public function down(): void
    {
        if (! Schema::hasTable('daily_attendance_results')) {
            return;
        }

        Schema::table('daily_attendance_results', function (Blueprint $table) {
            foreach (['break_minutes', 'attendance_value'] as $column) {
                if (Schema::hasColumn('daily_attendance_results', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
