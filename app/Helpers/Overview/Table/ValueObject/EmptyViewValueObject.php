<?php

namespace App\Helpers\Overview\Table\ValueObject;

use App\Helpers\View\ValueObject\ButtonValueObject;
use Illuminate\Support\Facades\Vite;

class EmptyViewValueObject
{

    public function __construct(
        private string $title,
        private string $description,
        private ?string $image = null,
        private ?ButtonValueObject $buttonValueObject = null,
    )
    {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        if (!$this->hasImage()) {
            return null;
        }

        return Vite::asset($this->image);
    }

    public function hasImage(): bool
    {
        return $this->image !== null;
    }

    /**
     * @return ButtonValueObject|null
     */
    public function getButton(): ?ButtonValueObject
    {
        return $this->buttonValueObject;
    }

    public function hasButton(): bool
    {
        return $this->buttonValueObject !== null;
    }

    public function render(): string
    {
        return view('overview/empty_table_view', [
            'valueObject' => $this,
        ])->render();
    }
}
