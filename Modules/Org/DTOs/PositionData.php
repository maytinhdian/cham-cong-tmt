<?php

namespace Modules\Org\DTOs;

class PositionData
{
    public function __construct(
        public string $code,
        public string $name,
        public ?string $level = null,
        public int $sortOrder = 0,
        public string $status = 'active',
        public ?string $description = null,
    ) {
    }

    /**
     * Convert position form data into database columns.
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'level' => $this->level,
            'sort_order' => $this->sortOrder,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
