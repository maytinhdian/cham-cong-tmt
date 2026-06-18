<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the device registry used before syncing raw attendance logs.
     */
    public function up(): void
    {
        if (Schema::hasTable('attendance_devices')) {
            Schema::table('attendance_devices', function (Blueprint $table) {
                if (! Schema::hasColumn('attendance_devices', 'device_type')) {
                    $table->string('device_type', 80)->default('zkteco')->after('name');
                }

                if (! Schema::hasColumn('attendance_devices', 'ip_address')) {
                    $table->string('ip_address', 45)->nullable()->after('device_type');
                }

                if (! Schema::hasColumn('attendance_devices', 'port')) {
                    $table->unsignedInteger('port')->default(4370)->after('ip_address');
                }

                if (! Schema::hasColumn('attendance_devices', 'location')) {
                    $table->string('location')->nullable()->after('port');
                }

                if (! Schema::hasColumn('attendance_devices', 'connection_status')) {
                    $table->string('connection_status', 40)->default('unknown')->index()->after('location');
                }

                if (! Schema::hasColumn('attendance_devices', 'sync_status')) {
                    $table->string('sync_status', 40)->default('idle')->index()->after('connection_status');
                }

                if (! Schema::hasColumn('attendance_devices', 'last_connected_at')) {
                    $table->timestamp('last_connected_at')->nullable()->after('sync_status');
                }

                if (! Schema::hasColumn('attendance_devices', 'last_synced_at')) {
                    $table->timestamp('last_synced_at')->nullable()->after('last_connected_at');
                }

                if (! Schema::hasColumn('attendance_devices', 'note')) {
                    $table->text('note')->nullable()->after('last_synced_at');
                }

                if (! Schema::hasColumn('attendance_devices', 'deleted_at')) {
                    $table->softDeletes();
                }
            });

            return;
        }

        Schema::create('attendance_devices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('device_type', 80)->default('zkteco');
            $table->string('ip_address', 45)->nullable();
            $table->unsignedInteger('port')->default(4370);
            $table->string('location')->nullable();
            $table->string('connection_status', 40)->default('unknown')->index();
            $table->string('sync_status', 40)->default('idle')->index();
            $table->timestamp('last_connected_at')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Drop the device registry if the device module is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_devices');
    }
};
