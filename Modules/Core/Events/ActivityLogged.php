<?php

namespace Modules\Core\Events;

use Modules\Core\Models\ActivityLog;

class ActivityLogged
{
    /**
     * Publish a Core audit event after an activity row has been persisted.
     */
    public function __construct(public readonly ActivityLog $activityLog)
    {
    }
}
