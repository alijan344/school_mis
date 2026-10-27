<?php

namespace App\Models\Concerns;

use LogicException;

trait HasCompositePrimaryKey
{
    protected function getCompositeKeyColumns(): array
    {
        return [];
    }

    protected function setKeysForSaveQuery($query)
    {
        return $this->applyCompositeKeyConstraints($query);
    }

    protected function setKeysForSelectQuery($query)
    {
        return $this->applyCompositeKeyConstraints($query);
    }

    protected function applyCompositeKeyConstraints($query)
    {
        $columns = $this->getCompositeKeyColumns();

        if ($columns === []) {
            throw new LogicException(
                'Composite key columns are not configured for '
                . static::class
            );
        }

        foreach ($columns as $column) {
            $value = $this->getRawOriginal($column);

            if ($value === null) {
                $value = $this->getAttribute($column);
            }

            if ($value === null) {
                throw new LogicException(
                    "Missing composite key value: {$column}"
                );
            }

            $query->where(
                $this->qualifyColumn($column),
                '=',
                $value
            );
        }

        return $query;
    }
}