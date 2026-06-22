<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create pending command storage used by ZKTeco PUSH devices when polling getrequest.
     */
    public function up(): void
    {
        Schema::create('attendance_device_commands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_device_id')->constrained('attendance_devices')->cascadeOnDelete();
            $table->string('command_key', 80)->unique();
            $table->string('command', 80);
            $table->string('status', 40)->default('pending')->index();
            $table->text('payload')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->json('response_payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Drop queued device commands when rolling back PUSH command support.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_device_commands');
    }
};
