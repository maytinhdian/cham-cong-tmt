<?php

namespace Modules\Org\Actions;

use Modules\Org\DTOs\PositionData;
use Modules\Org\Models\Position;
use Modules\Org\Services\PositionService;

class CreatePositionAction
{
    public function __construct(private readonly PositionService $positionService)
    {
    }

    /**
     * Create a new job position from validated HR input.
     */
    public function execute(PositionData $data): Position
    {
        return $this->positionService->create($data);
    }
}
