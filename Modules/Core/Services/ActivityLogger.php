<?php

namespace Modules\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\DTOs\ActivityLogData;
use Modules\Core\Events\ActivityLogged;
use Modules\Core\Models\ActivityLog;

class ActivityLogger
{
    /**
     * Persist an activity row and publish an event for optional subscribers.
     */
    public function log(ActivityLogData $data): ActivityLog
    {
        $activityLog = ActivityLog::query()->create([
            'actor_id' => $data->actorId,
            'module' => $data->module,
            'action' => $data->action,
            'subject_type' => $data->subject?->getMorphClass(),
            'subject_id' => $data->subject?->getKey(),
            'description' => $data->description,
            'old_values' => $data->oldValues,
            'new_values' => $data->newValues,
            'metadata' => $data->metadata,
            'ip_address' => $data->ipAddress,
            'user_agent' => $data->userAgent,
        ]);

        event(new ActivityLogged($activityLog));

        return $activityLog;
    }

    /**
     * Persist a user-facing activity with request context when available.
     */
    public function logForCurrentRequest(
        string $module,
        string $action,
        ?Model $subject = null,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $metadata = null
    ): ActivityLog {
        $request = request();

        return $this->log(new ActivityLogData(
            module: $module,
            action: $action,
            actorId: auth()->id(),
            subject: $subject,
            description: $description,
            oldValues: $oldValues,
            newValues: $newValues,
            metadata: $metadata,
            ipAddress: $request?->ip(),
            userAgent: $request?->userAgent(),
        ));
    }
}
