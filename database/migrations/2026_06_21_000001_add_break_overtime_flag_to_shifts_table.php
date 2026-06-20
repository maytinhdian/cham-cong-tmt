<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the odd but supported rule that a shift break can also be counted as overtime.
     */
    public function up(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            if (! Schema::hasColumn('shifts', 'break_as_overtime_enabled')) {
                $table->boolean('break_as_overtime_enabled')->default(false)->after('break_minutes');
            }
        });
    }

    /**
     * Remove the break-as-overtime rule flag.
     */
    public function down(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            if (Schema::hasColumn('shifts', 'break_as_overtime_enabled')) {
                $table->dropColumn('break_as_overtime_enabled');
            }
        });
    }
};
