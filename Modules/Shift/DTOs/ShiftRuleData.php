<?php

namespace Modules\Shift\DTOs;

class ShiftRuleData
{
    public function __construct(
        public int $shiftId,
        public string $ruleKey,
        public ?string $ruleValue = null,
        public string $ruleType = 'string',
        public int $sortOrder = 0,
        public string $status = 'active',
        public ?string $description = null,
    ) {
    }

    /**
     * Convert rule input into database attributes for persistence.
     */
    public function toArray(): array
    {
        return [
            'shift_id' => $this->shiftId,
            'rule_key' => $this->ruleKey,
            'rule_value' => $this->ruleValue,
            'rule_type' => $this->ruleType,
            'sort_order' => $this->sortOrder,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
