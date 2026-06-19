<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create reusable shift rules for attendance processing.
     */
    public function up(): void
    {
        if (Schema::hasTable('shift_rules')) {
            return;
        }

        Schema::create('shift_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->string('rule_key', 100)->index();
            $table->string('rule_value')->nullable();
            $table->string('rule_type', 40)->default('string');
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 40)->default('active')->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['shift_id', 'rule_key']);
        });
    }

    /**
     * Remove rules when the shift rule layer is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_rules');
    }
};
