<?php

namespace App\Infrastructure\Custom\ValueObjects;

class PageHeaderValueOject
{
    /**
     * @param string $title
     * @param ButtonValueObject[] $buttons
     */
    public function __construct(
        private string $title,
        private array $buttons
    ) {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PageHeaderValueOject
     */
    public function setTitle(string $title): PageHeaderValueOject
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return ButtonValueObject[]
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    /**
     * @param ButtonValueObject[] $buttons
     * @return PageHeaderValueOject
     */
    public function setButtons(array $buttons): PageHeaderValueOject
    {
        $this->buttons = $buttons;
        return $this;
    }
}
