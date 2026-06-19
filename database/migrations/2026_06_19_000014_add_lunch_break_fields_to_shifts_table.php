<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add lunch break settings to shift definitions.
     */
    public function up(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            if (! Schema::hasColumn('shifts', 'break_start_time')) {
                $table->time('break_start_time')->nullable()->after('end_time');
            }

            if (! Schema::hasColumn('shifts', 'break_end_time')) {
                $table->time('break_end_time')->nullable()->after('break_start_time');
            }

            if (! Schema::hasColumn('shifts', 'break_minutes')) {
                $table->unsignedInteger('break_minutes')->default(0)->after('break_end_time');
            }
        });
    }

    /**
     * Remove lunch break settings when rolling back shift definition changes.
     */
    public function down(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            foreach (['break_start_time', 'break_end_time', 'break_minutes'] as $column) {
                if (Schema::hasColumn('shifts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
