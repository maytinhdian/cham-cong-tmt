<?php

namespace Modules\Org\Services;

use Modules\Org\DTOs\PositionData;
use Modules\Org\Models\Position;

class PositionService
{
    public function create(PositionData $data): Position
    {
        return Position::query()->create($data->toArray());
    }

    public function update(Position $position, PositionData $data): Position
    {
        $position->update($data->toArray());

        return $position->refresh();
    }
}
