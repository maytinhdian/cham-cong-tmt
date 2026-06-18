<?php

namespace Modules\User\DTOs;

class EmployeeData
{
    public function __construct(
        public ?int $userId,
        public ?int $departmentId,
        public ?int $positionId,
        public string $employeeCode,
        public string $fullName,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $gender = null,
        public ?string $dateOfBirth = null,
        public ?string $hireDate = null,
        public ?string $avatar = null,
        public string $workStatus = 'active',
        public ?string $note = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'department_id' => $this->departmentId,
            'position_id' => $this->positionId,
            'employee_code' => $this->employeeCode,
            'full_name' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'date_of_birth' => $this->dateOfBirth,
            'hire_date' => $this->hireDate,
            'avatar' => $this->avatar,
            'work_status' => $this->workStatus,
            'note' => $this->note,
        ];
    }
}
