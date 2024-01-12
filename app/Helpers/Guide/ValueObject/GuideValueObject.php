<?php

namespace App\Helpers\Guide\ValueObject;

class GuideValueObject
{
    public function __construct(
        private string $title,
        private ?string $description,
        private array $items,
    )
    {
    }

    public static function make(
        string $title,
        ?string $description,
        array $items,
    ): self
    {
        return new self(
            title: $title,
            description: $description,
            items: $items,
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function hasDescription(): bool
    {
        return $this->description !== null;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
