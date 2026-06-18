<?php

namespace Modules\Core\DTOs;

use Illuminate\Database\Eloquent\Model;

readonly class ActivityLogData
{
    /**
     * Carry normalized audit information from business modules into Core logging.
     */
    public function __construct(
        public string $module,
        public string $action,
        public ?int $actorId = null,
        public ?Model $subject = null,
        public ?string $description = null,
        public ?array $oldValues = null,
        public ?array $newValues = null,
        public ?array $metadata = null,
        public ?string $ipAddress = null,
        public ?string $userAgent = null,
    ) {
    }
}
