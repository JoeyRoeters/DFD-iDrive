<?php

namespace App\Helpers\View\ValueObject;

use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Helpers\SweetAlert\SweetAlert;
use App\Helpers\SweetAlert\SweetAlertType;
use App\Helpers\View\Enum\ButtonSizeEnum;

class ButtonValueObject
{
    private string $id;

    public function __construct(
        private string $label,
        private ?RouteValueObject $route = null,
        private ?string $icon = null,
        private ?string $confirmMessage = null,
        private string $color = 'primary',
        private ButtonSizeEnum $size = ButtonSizeEnum::MEDIUM,
        private ?string $jsFunction = null,
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
     * @return string|null
     */
    public function getJsFunction(): ?string
    {
        return $this->jsFunction;
    }

    /**
     * @param string|null $jsFunction
     * @return ButtonValueObject
     */
    public function setJsFunction(?string $jsFunction): ButtonValueObject
    {
        $this->jsFunction = $jsFunction;

        return $this;
    }

    /**
     * @return RouteValueObject|null
     */
    public function getRoute(): ?RouteValueObject
    {
        return $this->route;
    }

    /**
     * @return bool
     */
    public function hasRoute(): bool
    {
        return $this->route instanceof RouteValueObject;
    }

    /**
     * @return bool
     */
    public function hasJsFunction(): bool
    {
        return $this->jsFunction !== null;
    }

    /**
     * @return string|null
     */
    public function getRouteUri(): ?string
    {
        if (!$this->hasRoute()) {
            return null;
        }

        return $this->route->getUri();
    }

    /**
     * @return bool
     */
    public function hasConfirmMessage(): bool
    {
        return $this->confirmMessage !== null;
    }

    /**
     * @param RouteValueObject $route
     * @return ButtonValueObject
     */
    public function setRoute(RouteValueObject $route): ButtonValueObject
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return ButtonSizeEnum
     */
    public function getSize(): ButtonSizeEnum
    {
        return $this->size;
    }

    /**
     * @param ButtonSizeEnum $size
     * @return ButtonValueObject
     */
    public function setSize(ButtonSizeEnum $size): ButtonValueObject
    {
        $this->size = $size;
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
        $this->setColor('danger');

        $this->confirmMessage = $confirmMessage;
        return $this;
    }

    public static function make(string $label, ?string $icon = null, ?RouteValueObject $route = null): self
    {
        return new self($label, $route, $icon);
    }

    public function render(): string
    {
        return view('components/button_value_object', [
            'button' => $this
        ])->render();
    }
}
