<?php

namespace App\Helpers\Guide\ValueObject;

use App\Helpers\View\ValueObject\ButtonValueObject;

class GuideItemValueObject
{
    public function __construct(
        private string $icon,
        private string $title,
        private ?string $description = null,
        private ?ButtonValueObject $button = null,
    )
    {
    }

    public static function make(
        string $icon,
        string $title,
        ?string $description = null,
        ?ButtonValueObject $button = null,
    ): self
    {
        return new self(
            icon: $icon,
            title: $title,
            description: $description,
            button: $button,
        );
    }

    public function getIcon(): string
    {
        return $this->icon;
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

    public function hasButton(): bool
    {
        return $this->button !== null;
    }

    public function getButton(): ?ButtonValueObject
    {
        return $this->button;
    }
}
