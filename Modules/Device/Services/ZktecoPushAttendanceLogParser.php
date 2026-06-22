<?php

namespace Modules\Device\Services;

use Modules\Device\DTOs\ZktecoPushAttendanceLogData;

class ZktecoPushAttendanceLogParser
{
    /**
     * Parse ATTLOG request content into individual punch records.
     */
    public function parse(string $payload): array
    {
        $logs = [];

        foreach (preg_split('/\r\n|\r|\n/', trim($payload)) ?: [] as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $logs[] = $this->parseLine($line);
        }

        return array_values(array_filter($logs));
    }

    /**
     * Parse one ATTLOG line from the device into business fields.
     */
    private function parseLine(string $line): ?ZktecoPushAttendanceLogData
    {
        if (! preg_match('/^(\S+)\s+(\d{4}-\d{2}-\d{2})\s+(\d{1,2}\s*:\s*\d{1,2}\s*:\s*\d{1,2})(?:\s+(.*))?$/', $line, $matches)) {
            return null;
        }

        $tail = preg_split('/\s+/', trim($matches[4] ?? '')) ?: [];
        $time = preg_replace('/\s+/', '', $matches[3]);

        return new ZktecoPushAttendanceLogData(
            deviceUserCode: $matches[1],
            punchTime: $matches[2] . ' ' . $time,
            status: (string) ($tail[0] ?? 'unknown'),
            verifyType: isset($tail[1]) ? $this->mapVerifyType((string) $tail[1]) : null,
            workCode: isset($tail[2]) ? (string) $tail[2] : null,
            reserved: array_slice($tail, 3) ?: null,
            rawLine: $line,
        );
    }

    /**
     * Convert common ZKTeco verify codes into readable raw log values.
     */
    private function mapVerifyType(string $verifyCode): string
    {
        return match ($verifyCode) {
            '0' => 'password',
            '1' => 'fingerprint',
            '2' => 'card',
            '15' => 'face',
            default => 'code_' . $verifyCode,
        };
    }
}
