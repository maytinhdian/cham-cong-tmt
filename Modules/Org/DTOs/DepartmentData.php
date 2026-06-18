<?php

namespace Modules\Org\DTOs;

class DepartmentData
{
    public function __construct(
        public ?int $parentId,
        public string $code,
        public string $name,
        public ?string $managerName = null,
        public ?string $phone = null,
        public ?string $email = null,
        public int $sortOrder = 0,
        public string $status = 'active',
        public ?string $description = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'parent_id' => $this->parentId,
            'code' => $this->code,
            'name' => $this->name,
            'manager_name' => $this->managerName,
            'phone' => $this->phone,
            'email' => $this->email,
            'sort_order' => $this->sortOrder,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
