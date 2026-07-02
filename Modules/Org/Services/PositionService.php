<?php

namespace Modules\Org\Services;

use Modules\Org\DTOs\PositionData;
use Modules\Org\Models\Position;

class PositionService
{
    /**
     * Persist a new position used for employee assignment and reporting.
     */
    public function create(PositionData $data): Position
    {
        return Position::query()->create($data->toArray());
    }

    /**
     * Update position identity, level, and status used by HR workflows.
     */
    public function update(Position $position, PositionData $data): Position
    {
        $position->update($data->toArray());

        return $position->refresh();
    }
}
