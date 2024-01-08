<?php

namespace App\Helpers\View\ValueObject;

class PageHeaderValueOject
{
    /**
     * @param string $title
     * @param string $subtitle
     * @param ButtonValueObject[] $buttons
     */
    public function __construct(
        private string $title,
        private string $subtitle = "",
        private array $buttons = []
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
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     * @return PageHeaderValueOject
     */

    public function setSubtitle(string $subtitle): PageHeaderValueOject
    {
        $this->subtitle = $subtitle;
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
