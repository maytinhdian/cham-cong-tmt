<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create payroll-ready monthly attendance summaries from daily results.
     */
    public function up(): void
    {
        if (Schema::hasTable('monthly_timesheets')) {
            return;
        }

        Schema::create('monthly_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->date('period_month')->index();
            $table->unsignedInteger('total_days')->default(0);
            $table->unsignedInteger('work_days')->default(0);
            $table->unsignedInteger('adjusted_days')->default(0);
            $table->unsignedInteger('exception_days')->default(0);
            $table->unsignedInteger('absent_days')->default(0);
            $table->unsignedInteger('leave_days')->default(0);
            $table->unsignedInteger('weekend_days')->default(0);
            $table->unsignedInteger('holiday_days')->default(0);
            $table->unsignedInteger('missing_log_count')->default(0);
            $table->unsignedInteger('work_minutes')->default(0);
            $table->unsignedInteger('break_minutes')->default(0);
            $table->decimal('attendance_value', 8, 2)->default(0);
            $table->unsignedInteger('late_minutes')->default(0);
            $table->unsignedInteger('early_leave_minutes')->default(0);
            $table->unsignedInteger('overtime_minutes')->default(0);
            $table->string('status', 40)->default('draft')->index();
            $table->timestamp('generated_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['employee_id', 'period_month'], 'monthly_timesheet_employee_period_unique');
        });
    }

    /**
     * Drop monthly summaries when rolling back the monthly timesheet feature.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_timesheets');
    }
};
