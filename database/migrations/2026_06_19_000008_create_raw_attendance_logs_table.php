<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the raw punch log table imported from attendance devices.
     */
    public function up(): void
    {
        if (Schema::hasTable('raw_attendance_logs')) {
            return;
        }

        Schema::create('raw_attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_device_id')->nullable()->constrained('attendance_devices')->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->string('device_user_code')->index();
            $table->timestamp('punch_time')->index();
            $table->string('punch_type', 40)->default('unknown')->index();
            $table->string('verify_type', 80)->nullable();
            $table->string('source', 80)->default('device')->index();
            $table->string('processing_status', 40)->default('pending')->index();
            $table->json('raw_payload')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['attendance_device_id', 'device_user_code', 'punch_time'], 'raw_logs_device_user_time_unique');
        });
    }

    /**
     * Drop raw logs when rolling back the first raw attendance import layer.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_attendance_logs');
    }
};
