<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create approved leave records used by attendance processing.
     */
    public function up(): void
    {
        if (Schema::hasTable('approved_leaves')) {
            return;
        }

        Schema::create('approved_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->date('leave_date')->index();
            $table->string('leave_type', 80)->default('leave')->index();
            $table->decimal('workday_value', 4, 2)->default(0);
            $table->string('status', 40)->default('approved')->index();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['employee_id', 'leave_date'], 'approved_leave_employee_date_unique');
        });
    }

    /**
     * Drop approved leave records when the leave rule layer is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('approved_leaves');
    }
};
