<?php

namespace Modules\Shift\Services;

use Modules\Shift\DTOs\ShiftData;
use Modules\Shift\Models\Shift;

class ShiftService
{
    /**
     * Create a shift definition for scheduling and attendance calculation.
     */
    public function create(ShiftData $data): Shift
    {
        return Shift::query()->create($data->toArray());
    }

    /**
     * Update the time windows and calculation settings of a shift.
     */
    public function update(Shift $shift, ShiftData $data): Shift
    {
        $shift->update($data->toArray());

        return $shift->refresh();
    }

    /**
     * Retire an unused shift while preserving historical records.
     */
    public function delete(Shift $shift): void
    {
        $shift->delete();
    }
}
