<?php

namespace App\Helpers\Overview\Column\ValueObject;

use App\Helpers\Overview\Column\Interface\RenderTypeInterface;

class MultiActionRenderType implements RenderTypeInterface
{
    /**
     * @param ActionRenderType[] $actions
     */
    public function __construct(
        private array $actions
    ) {
    }

    public function format(): string
    {
        return json_encode(array_map(fn (ActionRenderType $action) => $action->format(), $this->actions));
    }
}
