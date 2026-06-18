<?php

namespace Modules\Shift\Actions;

use Modules\Shift\DTOs\ShiftData;
use Modules\Shift\Models\Shift;
use Modules\Shift\Services\ShiftService;

class CreateShiftAction
{
    public function __construct(private readonly ShiftService $shiftService)
    {
    }

    public function execute(ShiftData $data): Shift
    {
        return $this->shiftService->create($data);
    }
}
