<?php

namespace Modules\Shift\Services;

use Modules\Shift\DTOs\ShiftData;
use Modules\Shift\Models\Shift;

class ShiftService
{
    public function create(ShiftData $data): Shift
    {
        return Shift::query()->create($data->toArray());
    }

    public function update(Shift $shift, ShiftData $data): Shift
    {
        $shift->update($data->toArray());

        return $shift->refresh();
    }
}
