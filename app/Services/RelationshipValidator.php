<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class RelationshipValidator
{
    const NESTED_SET_FIELDS = ['_lft', '_rgt'];

    const SELF_REFERENCE_FIELDS = ['parent_id'];

    public function getRelationTable(string $field, string $currentTable): ?string
    {
        if (in_array($field, self::SELF_REFERENCE_FIELDS)) {
            return $currentTable;
        }

        if (str_ends_with($field, '_id')) {
            $singular = substr($field, 0, -3);
            return Str::plural($singular);
        }

        return null;
    }

    public function validateReference(string $table, $value): bool
    {
        if (empty($value) || $value === '0' || $value === 0) {
            return true;
        }

        return DB::table($table)->where('id', $value)->exists();
    }

    public function sanitizeValue(string $field, $value, string $currentTable): mixed
    {
        if (in_array($field, self::NESTED_SET_FIELDS)) {
            return null;
        }

        if ($value === null || $value === '' || $value === '0' || $value === 0) {
            return null;
        }

        $targetTable = $this->getRelationTable($field, $currentTable);

        if (!$targetTable) {
            return $value;
        }

        if (!Schema::hasTable($targetTable)) {
            return $value;
        }

        if ($this->validateReference($targetTable, $value)) {
            return $value;
        }

        return null;
    }

    public function isRelationalField(string $field): bool
    {
        if (in_array($field, self::NESTED_SET_FIELDS)) {
            return true;
        }

        if (in_array($field, self::SELF_REFERENCE_FIELDS)) {
            return true;
        }

        return str_ends_with($field, '_id');
    }
}
