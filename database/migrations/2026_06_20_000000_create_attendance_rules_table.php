<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create global attendance calculation rules used by processing screens.
     */
    public function up(): void
    {
        if (Schema::hasTable('attendance_rules')) {
            return;
        }

        Schema::create('attendance_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_key', 100)->unique();
            $table->text('rule_value')->nullable();
            $table->string('rule_type', 40)->default('string');
            $table->string('group_key', 60)->default('general')->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 40)->default('active')->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Remove global attendance rules when rolling back the settings feature.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_rules');
    }
};
