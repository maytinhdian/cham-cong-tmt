<?php

namespace Modules\Shift\Services;

use Modules\Shift\DTOs\ShiftBreakData;
use Modules\Shift\Models\ShiftBreak;

class ShiftBreakService
{
    /**
     * Create a break window for a shift.
     */
    public function create(ShiftBreakData $data): ShiftBreak
    {
        return ShiftBreak::query()->create($data->toArray());
    }

    /**
     * Update the break window details for a shift.
     */
    public function update(ShiftBreak $shiftBreak, ShiftBreakData $data): ShiftBreak
    {
        $shiftBreak->update($data->toArray());

        return $shiftBreak->refresh();
    }

    /**
     * Remove an obsolete break definition from a shift.
     */
    public function delete(ShiftBreak $shiftBreak): void
    {
        $shiftBreak->delete();
    }
}
