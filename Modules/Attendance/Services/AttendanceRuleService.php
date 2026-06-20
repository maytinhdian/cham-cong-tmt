<?php

namespace Modules\Attendance\Services;

use Illuminate\Support\Collection;
use Modules\Attendance\DTOs\AttendanceRuleData;
use Modules\Attendance\Models\AttendanceRule;

class AttendanceRuleService
{
    /**
     * Return saved attendance rules keyed by their business setting key.
     */
    public function keyed(): Collection
    {
        return AttendanceRule::query()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get()
            ->keyBy('rule_key');
    }

    /**
     * Merge saved rule values over the defaults used by the settings page.
     */
    public function valuesWithDefaults(array $defaults): array
    {
        $savedRules = $this->keyed();

        foreach ($defaults as $key => $default) {
            if (! $savedRules->has($key)) {
                continue;
            }

            $defaults[$key]['value'] = $this->castValue(
                $savedRules->get($key)->rule_value,
                $defaults[$key]['type']
            );
        }

        return $defaults;
    }

    /**
     * Persist the complete set of global attendance calculation settings.
     */
    public function sync(array $rules, array $definitions): void
    {
        foreach ($rules as $key => $value) {
            if (! isset($definitions[$key])) {
                continue;
            }

            $definition = $definitions[$key];

            AttendanceRule::query()->updateOrCreate(
                ['rule_key' => $key],
                (new AttendanceRuleData(
                    ruleKey: $key,
                    ruleValue: $this->stringValue($value, $definition['type']),
                    ruleType: $definition['type'],
                    groupKey: $definition['group'],
                    sortOrder: $definition['sort'],
                    description: $definition['description'],
                ))->toArray()
            );
        }
    }

    /**
     * Cast a stored string value into the expected Livewire property type.
     */
    private function castValue(?string $value, string $type): mixed
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'decimal' => (string) $value,
            default => $value,
        };
    }

    /**
     * Normalize typed form values into strings for key-value storage.
     */
    private function stringValue(mixed $value, string $type): ?string
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'boolean' => $value ? '1' : '0',
            default => (string) $value,
        };
    }
}
