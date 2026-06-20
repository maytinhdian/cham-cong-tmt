<?php

namespace Modules\Attendance\DTOs;

class AttendanceRuleData
{
    public function __construct(
        public string $ruleKey,
        public ?string $ruleValue,
        public string $ruleType = 'string',
        public string $groupKey = 'general',
        public int $sortOrder = 0,
        public string $status = 'active',
        public ?string $description = null,
    ) {
    }

    /**
     * Convert attendance rule input into persisted database attributes.
     */
    public function toArray(): array
    {
        return [
            'rule_key' => $this->ruleKey,
            'rule_value' => $this->ruleValue,
            'rule_type' => $this->ruleType,
            'group_key' => $this->groupKey,
            'sort_order' => $this->sortOrder,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
