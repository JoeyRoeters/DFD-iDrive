<?php

namespace App\Helpers\View\ValueObject;

use App\Helpers\SweetAlert\SweetAlert;
use App\Helpers\SweetAlert\SweetAlertType;

class ButtonValueObject
{
    private string $id;

    public function __construct(
        private string $label,
        private string $route,
        private string $icon,
        private string $color,
        private ?string $confirmMessage = null,
    ) {
        $this->id = uniqid();
    }

    public function getRandomId(): string
    {
        return $this->id;
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

    /**
     * @return string|null
     */
    public function getConfirmMessage(): ?string
    {
        return $this->confirmMessage;
    }

    /**
     * @return array
     */
    public function getSweetAlert(): array
    {
        $sweetAlert = new SweetAlert(
            SweetAlertType::info,
            $this->getConfirmMessage() ?? "Are you sure you want to continue?",
            false
        );

        $sweetAlert->setTitle('Are you sure?');
        $sweetAlert->setConfirmButtonText('Yes');
        $sweetAlert->setCancelButtonText('No');

        return $sweetAlert->toArray();
    }

    /**
     * @param string|null $confirmMessage
     * @return ButtonValueObject
     */
    public function setConfirmMessage(?string $confirmMessage): ButtonValueObject
    {
        $this->confirmMessage = $confirmMessage;
        return $this;
    }

    public static function make(string $label, string $route, string $icon, string $color = 'primary', ?string $confirmMessage = null): self
    {
        return new self($label, $route, $icon, $color, $confirmMessage);
    }
}
