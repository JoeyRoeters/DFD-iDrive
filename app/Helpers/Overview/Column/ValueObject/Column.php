<?php

namespace App\Helpers\Overview\Column\ValueObject;

use App\Helpers\Overview\Column\Enum\RenderTypeEnum;

class Column
{
    public function __construct(
        private string $key,
        private string $label,
        private RenderTypeEnum $renderType = RenderTypeEnum::TEXT,
    ) {
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Column
     */
    public function setKey(string $key): Column
    {
        $this->key = $key;
        return $this;
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
     * @return Column
     */
    public function setLabel(string $label): Column
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return RenderTypeEnum
     */
    public function getRenderType(): RenderTypeEnum
    {
        return $this->renderType;
    }

    /**
     * @param RenderTypeEnum $renderType
     * @return Column
     */
    public function setRenderType(RenderTypeEnum $renderType): Column
    {
        $this->renderType = $renderType;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'renderType' => $this->getRenderType()->getType()
        ];
    }

}
