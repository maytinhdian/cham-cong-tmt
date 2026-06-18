<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('clock_in_from')->nullable();
            $table->time('clock_in_to')->nullable();
            $table->time('clock_out_from')->nullable();
            $table->time('clock_out_to')->nullable();
            $table->unsignedInteger('max_late_minutes')->default(0);
            $table->unsignedInteger('max_early_leave_minutes')->default(0);
            $table->decimal('workday_value', 4, 2)->default(1);
            $table->unsignedInteger('standard_work_minutes')->default(480);
            $table->boolean('requires_clock_in')->default(true);
            $table->boolean('requires_clock_out')->default(true);
            $table->string('display_color', 20)->default('#3b82f6');
            $table->string('status', 40)->default('active')->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
