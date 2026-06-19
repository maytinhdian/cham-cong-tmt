<?php

namespace Modules\Shift\Services;

use Modules\Shift\DTOs\ShiftRuleData;
use Modules\Shift\Models\ShiftRule;

class ShiftRuleService
{
    /**
     * Create a rule used by attendance processing for a shift.
     */
    public function create(ShiftRuleData $data): ShiftRule
    {
        return ShiftRule::query()->create($data->toArray());
    }

    /**
     * Update the rule settings used for shift attendance processing.
     */
    public function update(ShiftRule $shiftRule, ShiftRuleData $data): ShiftRule
    {
        $shiftRule->update($data->toArray());

        return $shiftRule->refresh();
    }

    /**
     * Remove a shift rule that is no longer needed.
     */
    public function delete(ShiftRule $shiftRule): void
    {
        $shiftRule->delete();
    }
}
