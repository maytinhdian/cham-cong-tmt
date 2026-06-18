<?php

namespace Modules\Core\Subscribers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Modules\Core\Events\ActivityLogged;

class ActivityEventSubscriber
{
    /**
     * Handle persisted activity events for lightweight diagnostics.
     */
    public function handleActivityLogged(ActivityLogged $event): void
    {
        Log::info('Core activity logged', [
            'activity_log_id' => $event->activityLog->id,
            'module' => $event->activityLog->module,
            'action' => $event->activityLog->action,
        ]);
    }

    /**
     * Register Core activity event handlers with Laravel's dispatcher.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            ActivityLogged::class,
            [self::class, 'handleActivityLogged']
        );
    }
}
