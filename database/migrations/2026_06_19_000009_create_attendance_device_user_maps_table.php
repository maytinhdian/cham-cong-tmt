<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create mappings between device user codes and internal employees.
     */
    public function up(): void
    {
        if (Schema::hasTable('attendance_device_user_maps')) {
            return;
        }

        Schema::create('attendance_device_user_maps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_device_id')->constrained('attendance_devices')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('device_user_code');
            $table->string('device_user_name')->nullable();
            $table->string('status', 40)->default('active')->index();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['attendance_device_id', 'device_user_code'], 'device_user_map_unique');
        });
    }

    /**
     * Drop device-user mappings when rolling back the device mapping layer.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_device_user_maps');
    }
};
