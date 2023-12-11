<?php

namespace App\Helpers\Overview\Column\ValueObject;

use App\Helpers\Overview\Column\Enum\ActionButtonEnum;
use App\Helpers\Overview\Column\Interface\RenderTypeInterface;

class ActionRenderType implements RenderTypeInterface
{
    public string $link;

    public function __construct(
        private string $route,
        private ActionButtonEnum $buttonEnum,
        private array $routeParam = [],
        private ?string $label = null,
        private ?string $icon = null,
        private ?string $color = null
    ) {
        $this->link = route($this->route, $this->routeParam);
    }

    public function format(): string
    {
        return json_encode([
            'buttonEnum' => $this->buttonEnum->value(),
            'label' => $this->label,
            'icon' => $this->icon,
            'color' => $this->color,
            'link' => $this->link
        ]);
    }
}
