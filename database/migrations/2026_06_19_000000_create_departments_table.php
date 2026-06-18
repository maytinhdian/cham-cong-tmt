<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('departments')) {
            Schema::table('departments', function (Blueprint $table) {
                if (! Schema::hasColumn('departments', 'parent_id')) {
                    $table->foreignId('parent_id')->nullable()->after('id')->constrained('departments')->nullOnDelete();
                }

                if (! Schema::hasColumn('departments', 'manager_name')) {
                    $table->string('manager_name')->nullable()->after('name');
                }

                if (! Schema::hasColumn('departments', 'phone')) {
                    $table->string('phone')->nullable()->after('manager_name');
                }

                if (! Schema::hasColumn('departments', 'email')) {
                    $table->string('email')->nullable()->after('phone');
                }

                if (! Schema::hasColumn('departments', 'sort_order')) {
                    $table->unsignedInteger('sort_order')->default(0)->after('email');
                }

                if (! Schema::hasColumn('departments', 'deleted_at')) {
                    $table->softDeletes();
                }
            });

            return;
        }

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('manager_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 40)->default('active')->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('departments')) {
            return;
        }

        Schema::table('departments', function (Blueprint $table) {
            foreach (['parent_id', 'manager_name', 'phone', 'email', 'sort_order', 'deleted_at'] as $column) {
                if (Schema::hasColumn('departments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
