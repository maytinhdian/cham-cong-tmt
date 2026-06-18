<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('shifts')) {
            Schema::table('shifts', function (Blueprint $table) {
                if (! Schema::hasColumn('shifts', 'clock_in_from')) {
                    $table->time('clock_in_from')->nullable()->after('end_time');
                }

                if (! Schema::hasColumn('shifts', 'clock_in_to')) {
                    $table->time('clock_in_to')->nullable()->after('clock_in_from');
                }

                if (! Schema::hasColumn('shifts', 'clock_out_from')) {
                    $table->time('clock_out_from')->nullable()->after('clock_in_to');
                }

                if (! Schema::hasColumn('shifts', 'clock_out_to')) {
                    $table->time('clock_out_to')->nullable()->after('clock_out_from');
                }

                if (! Schema::hasColumn('shifts', 'max_late_minutes')) {
                    $table->unsignedInteger('max_late_minutes')->default(0)->after('clock_out_to');
                }

                if (! Schema::hasColumn('shifts', 'max_early_leave_minutes')) {
                    $table->unsignedInteger('max_early_leave_minutes')->default(0)->after('max_late_minutes');
                }

                if (! Schema::hasColumn('shifts', 'workday_value')) {
                    $table->decimal('workday_value', 4, 2)->default(1)->after('max_early_leave_minutes');
                }

                if (! Schema::hasColumn('shifts', 'standard_work_minutes')) {
                    $table->unsignedInteger('standard_work_minutes')->default(480)->after('workday_value');
                }

                if (! Schema::hasColumn('shifts', 'requires_clock_in')) {
                    $table->boolean('requires_clock_in')->default(true)->after('standard_work_minutes');
                }

                if (! Schema::hasColumn('shifts', 'requires_clock_out')) {
                    $table->boolean('requires_clock_out')->default(true)->after('requires_clock_in');
                }

                if (! Schema::hasColumn('shifts', 'display_color')) {
                    $table->string('display_color', 20)->default('#3b82f6')->after('requires_clock_out');
                }

                if (! Schema::hasColumn('shifts', 'description')) {
                    $table->text('description')->nullable()->after('status');
                }

                if (! Schema::hasColumn('shifts', 'deleted_at')) {
                    $table->softDeletes();
                }
            });

            return;
        }

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
        if (! Schema::hasTable('shifts')) {
            return;
        }

        Schema::table('shifts', function (Blueprint $table) {
            foreach ([
                'clock_in_from',
                'clock_in_to',
                'clock_out_from',
                'clock_out_to',
                'max_late_minutes',
                'max_early_leave_minutes',
                'workday_value',
                'standard_work_minutes',
                'requires_clock_in',
                'requires_clock_out',
                'display_color',
                'description',
                'deleted_at',
            ] as $column) {
                if (Schema::hasColumn('shifts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
