<?php

namespace App\Domain\Shared\Interface;

interface SearchableModelInterface
{
    /**
     * @return array<string>
     */
    public static function getSearchableFields(): array;
}
