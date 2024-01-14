<?php

namespace App\Helpers\Overview\Column\ValueObject;

use App\Helpers\Overview\Column\Enum\ActionButtonEnum;
use App\Helpers\Overview\Column\Interface\RenderTypeInterface;

class TripLabelRenderType implements RenderTypeInterface
{
    public function __construct(
        private string $tripNumber,
        private string $deviceName,
    ) {
    }

    public function format(): string
    {
        return json_encode([
            'tripNumber' => $this->tripNumber,
            'deviceName' => $this->deviceName,
        ]);
    }
}
