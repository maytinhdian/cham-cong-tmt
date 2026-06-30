<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create module/action permissions and role assignments for business access control.
     */
    public function up(): void
    {
        if (! Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('label')->nullable();
                $table->string('module', 80)->index();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('permission_role')) {
            Schema::create('permission_role', function (Blueprint $table) {
                $table->id();
                $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
                $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['permission_id', 'role_id']);
            });
        }
    }

    /**
     * Remove business permission tables when rolling back the authorization foundation.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
    }
};
