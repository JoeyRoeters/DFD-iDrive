<?php

namespace App\Domain\Shared\ValueObject;

use http\QueryString;

class RouteValueObject
{
    public function __construct(
        private string $name,
        private array $parameters = [],
        private bool $absolute = false,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getUri(): string
    {
        if ($this->absolute) {
            $url = $this->name;
            if (count($this->parameters) > 0) {
                $url .= '?' . http_build_query($this->parameters);
            }

            return $url;
        }

        return route($this->name, $this->parameters);
    }
}
