<?php

namespace Modules\Attendance\DTOs;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

readonly class LogPairingResult
{
    public function __construct(
        public Collection $logs,
        public ?CarbonInterface $clockIn,
        public ?CarbonInterface $clockOut,
        public int $matchedLogCount,
    ) {
    }
}
