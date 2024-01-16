<?php

namespace App\Domain\Shared\Interface;

interface SearchableModelStringInterface
{
    /**
     * @return string
     */
    public function getSearchableString(): string;
}
