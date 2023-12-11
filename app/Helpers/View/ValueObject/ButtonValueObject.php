<?php

namespace App\Helpers\View\ValueObject;

class ButtonValueObject
{
    public function __construct(
        private string $label,
        private string $route,
        private string $icon,
        private string $color
    ) {
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return ButtonValueObject
     */
    public function setLabel(string $label): ButtonValueObject
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return ButtonValueObject
     */
    public function setRoute(string $route): ButtonValueObject
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return ButtonValueObject
     */
    public function setIcon(string $icon): ButtonValueObject
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return ButtonValueObject
     */
    public function setColor(string $color): ButtonValueObject
    {
        $this->color = $color;
        return $this;
    }

    public static function make(string $label, string $route, string $icon, string $color = 'primary'): self
    {
        return new self($label, $route, $icon, $color);
    }
}
