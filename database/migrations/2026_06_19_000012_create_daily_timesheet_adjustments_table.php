<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create adjustment history for manually corrected daily attendance results.
     */
    public function up(): void
    {
        if (Schema::hasTable('daily_timesheet_adjustments')) {
            return;
        }

        Schema::create('daily_timesheet_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_attendance_result_id')->constrained('daily_attendance_results')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('adjusted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('work_date')->index();
            $table->json('old_values');
            $table->json('new_values');
            $table->text('reason');
            $table->string('status', 40)->default('applied')->index();
            $table->timestamps();
        });
    }

    /**
     * Drop manual timesheet adjustment history when rolling back this layer.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_timesheet_adjustments');
    }
};
