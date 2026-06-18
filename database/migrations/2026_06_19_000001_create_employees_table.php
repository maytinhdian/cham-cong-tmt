<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('department_id')->nullable()->index();
            $table->unsignedBigInteger('position_id')->nullable()->index();
            $table->string('employee_code')->unique();
            $table->string('full_name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('hire_date')->nullable();
            $table->string('avatar')->nullable();
            $table->string('work_status', 40)->default('active')->index();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
