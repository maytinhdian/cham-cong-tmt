<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create daily processed attendance results from raw punch logs.
     */
    public function up(): void
    {
        if (Schema::hasTable('daily_attendance_results')) {
            return;
        }

        Schema::create('daily_attendance_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_schedule_id')->nullable()->constrained('employee_schedules')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained()->nullOnDelete();
            $table->date('work_date')->index();
            $table->timestamp('clock_in_at')->nullable();
            $table->timestamp('clock_out_at')->nullable();
            $table->unsignedInteger('work_minutes')->default(0);
            $table->unsignedInteger('late_minutes')->default(0);
            $table->unsignedInteger('early_leave_minutes')->default(0);
            $table->unsignedInteger('overtime_minutes')->default(0);
            $table->unsignedInteger('missing_log_count')->default(0);
            $table->string('status', 40)->default('pending')->index();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['employee_id', 'work_date'], 'daily_attendance_employee_date_unique');
        });
    }

    /**
     * Drop daily attendance results when rolling back the processing layer.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_attendance_results');
    }
};
