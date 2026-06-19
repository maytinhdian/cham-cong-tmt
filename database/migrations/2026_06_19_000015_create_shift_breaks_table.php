<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create reusable break definitions for each shift.
     */
    public function up(): void
    {
        if (Schema::hasTable('shift_breaks')) {
            return;
        }

        Schema::create('shift_breaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('break_minutes')->default(0);
            $table->boolean('is_paid')->default(true);
            $table->string('status', 40)->default('active')->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['shift_id', 'status']);
        });
    }

    /**
     * Remove break definitions when the shift break layer is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_breaks');
    }
};
